<?php

namespace App\Services;

use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Support\Collection;

/**
 * Simple Additive Weighting (SAW) untuk SDM Award.
 *
 * Alur: Rubrik -> nilai per prestasi (40-100) -> akumulasi per tingkat kejuaraan
 *       dengan bobot (Nasional 0.5, Provinsi 0.3, Kab/Kota 0.2) -> 1 nilai siswa
 *       -> SAW ranking.
 *
 * Kriteria SAW = tingkat kejuaraan (C1=Nasional, C2=Provinsi, C3=Kab/Kota),
 * masing-masing benefit, dibobot sesuai panduan penilaian.
 */
class SawService
{
    public const BOBOT_TINGKAT = [
        'nasional' => 0.5,
        'provinsi' => 0.3,
        'kabupaten' => 0.2,
    ];

    public const TINGKAT_KE_KRITERIA = [
        'nasional' => 'C1',
        'provinsi' => 'C2',
        'kabupaten' => 'C3',
    ];

    /**
     * Hitung SAW untuk satu periode, dipecah PER KELAS.
     * Setiap kelas memiliki peringkat sendiri (Juara 1, 2, 3 dst per kelas).
     * @return Collection [{siswa, kelas_id, nilai_akhir, detail, jumlah_prestasi, peringkat}]
     */
    public function hitung(Periode $periode): Collection
    {
        $prestasis = Prestasi::with('siswa')
            ->where('periode_id', $periode->id)
            ->where('status_validasi', 'valid')
            ->get();

        $perSiswa = $prestasis->groupBy('siswa_id');

        // Matriks X per siswa: [siswa_id] = ['kelas_id'=>.., 'C1/C2/C3'=>..]
        $matriksX = [];
        $metaSiswa = [];
        foreach ($perSiswa as $siswaId => $items) {
            $siswa = $items->first()->siswa;
            $metaSiswa[$siswaId] = $siswa;
            $row = ['kelas_id' => $siswa?->kelas_id, 'C1' => 0, 'C2' => 0, 'C3' => 0];
            foreach ($items as $p) {
                $kode = self::TINGKAT_KE_KRITERIA[$p->tingkat] ?? null;
                if (! $kode) {
                    continue;
                }
                $row[$kode] += (float) ($p->nilai_rubrik ?? 0);
            }
            $matriksX[$siswaId] = $row;
        }

        // Kelompokkan siswa per kelas, lalu SAW per kelas (normalisasi + peringkat masing-masing)
        $hasil = collect();
        $grouped = [];
        foreach ($matriksX as $siswaId => $row) {
            $kelasId = $row['kelas_id'];
            $groupKey = $kelasId ?? 'tanpa-kelas';
            if (! isset($grouped[$groupKey])) {
                $grouped[$groupKey] = [];
            }
            $grouped[$groupKey][$siswaId] = $row;
        }

        foreach ($grouped as $rows) {
            // Normalisasi per kelas (benefit => nilai / max kelas tersebut)
            $maxPerKriteria = [];
            foreach (['C1', 'C2', 'C3'] as $kode) {
                $maxPerKriteria[$kode] = collect($rows)->max(fn ($r) => $r[$kode] ?? 0) ?: 1;
            }

            $hasilKelas = [];
            foreach ($rows as $siswaId => $row) {
                $totalVi = 0;
                $detail = [];
                foreach (['C1', 'C2', 'C3'] as $kode) {
                    $w = self::bobotKriteria($kode);
                    $x = $row[$kode] ?? 0;
                    $rnorm = $maxPerKriteria[$kode] ? $x / $maxPerKriteria[$kode] : 0;
                    $kontrib = $rnorm * $w;
                    $totalVi += $kontrib;
                    $detail[$kode] = [
                        'x' => round($x, 2),
                        'rnorm' => round($rnorm, 4),
                        'w' => $w,
                        'kontrib' => round($kontrib, 4),
                    ];
                }
                $nilaiAkhir = (float) ($row['C1'] * self::BOBOT_TINGKAT['nasional']
                    + $row['C2'] * self::BOBOT_TINGKAT['provinsi']
                    + $row['C3'] * self::BOBOT_TINGKAT['kabupaten']);

                $hasilKelas[] = [
                    'siswa' => $metaSiswa[$siswaId],
                    'kelas_id' => $row['kelas_id'],
                    'total_vi' => round($totalVi, 4),
                    'nilai_akhir' => round($nilaiAkhir, 2),
                    'detail' => $detail,
                    'jumlah_prestasi' => count($perSiswa[$siswaId]),
                ];
            }

            $hasilKelas = collect($hasilKelas)->sortByDesc('nilai_akhir')->values();

            $hasilKelas->transform(function ($item, $i) {
                $item['peringkat'] = $i + 1;

                return $item;
            });

            $hasil = $hasil->concat($hasilKelas);
        }

        return $hasil->sortBy([
            ['kelas_id', 'asc'],
            ['peringkat', 'asc'],
        ])->values();
    }

    protected static function bobotKriteria(string $kode): float
    {
        return match ($kode) {
            'C1' => self::BOBOT_TINGKAT['nasional'],
            'C2' => self::BOBOT_TINGKAT['provinsi'],
            'C3' => self::BOBOT_TINGKAT['kabupaten'],
            default => 0,
        };
    }

    /**
     * Hitung nilai sementara SAW untuk SATU siswa (on-the-fly).
     */
    public function hitungSiswa(Periode $periode, Siswa $siswa): ?array
    {
        $ranking = $this->hitung($periode);
        $item = $ranking->firstWhere('siswa.id', $siswa->id);

        if (! $item) {
            return null;
        }

        return [
            'total_vi' => $item['total_vi'],
            'nilai_akhir' => $item['nilai_akhir'],
            'peringkat' => $item['peringkat'],
            'jumlah_prestasi' => $item['jumlah_prestasi'],
        ];
    }
}
