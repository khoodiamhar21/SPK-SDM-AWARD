<?php

namespace App\Services;

use App\Models\Periode;
use App\Models\Prestasi;
use Illuminate\Support\Collection;

/**
 * Simple Additive Weighting (SAW) untuk SDM Award.
 * Konversi: tingkat (kota=1, provinsi=2, nasional=3, internasional=4)
 *           peringkat (juara1=3, juara2=2, juara3=1)
 * Hanya prestasi berstatus 'valid' & dalam periode yang dihitung.
 */
class SawService
{
    public const TINGKAT_SKALA = [
        'kota' => 1,
        'provinsi' => 2,
        'nasional' => 3,
        'internasional' => 4,
    ];

    public const PERINGKAT_SKALA = [
        'juara1' => 3,
        'juara2' => 2,
        'juara3' => 1,
    ];

    public static function skalaTingkat(string $tingkat): int
    {
        return self::TINGKAT_SKALA[$tingkat] ?? 0;
    }

    public static function skalaPeringkat(string $peringkat): int
    {
        return self::PERINGKAT_SKALA[$peringkat] ?? 0;
    }

    /**
     * Hitung SAW untuk satu periode.
     * @return Collection hasil peringkat: [{siswa, total_vi, detail: [{prestasi, x, rnorm, w, kontrib}]}]
     */
    public function hitung(Periode $periode): Collection
    {
        $bobots = $periode->bobots()->with('kriteria')->get();
        $prestasis = Prestasi::with('siswa')
            ->where('periode_id', $periode->id)
            ->where('status_validasi', 'valid')
            ->get();

        // Kelompokkan per siswa
        $perSiswa = $prestasis->groupBy('siswa_id');

        // Matriks X per kriteria (satu baris per siswa, agregat = sum skala prestasi)
        $matriksX = [];      // [siswa_id][kriteria_kode] = sum
        $metaSiswa = [];
        foreach ($perSiswa as $siswaId => $items) {
            $siswa = $items->first()->siswa;
            $metaSiswa[$siswaId] = $siswa;
            foreach (['tingkat' => 'C1', 'peringkat' => 'C2'] as $field => $kode) {
                $sum = $items->sum(function ($p) use ($field) {
                    return $field === 'tingkat'
                        ? self::skalaTingkat($p->tingkat)
                        : self::skalaPeringkat($p->peringkat);
                });
                $matriksX[$siswaId][$kode] = $sum;
            }
        }

        // Normalisasi (semua kriteria bersifat benefit => nilai/max)
        $maxPerKriteria = [];
        foreach (['C1', 'C2'] as $kode) {
            $maxPerKriteria[$kode] = collect($matriksX)->max(fn ($row) => $row[$kode] ?? 0) ?: 1;
        }

        $hasil = [];
        foreach ($matriksX as $siswaId => $row) {
            $totalVi = 0;
            $detail = [];
            foreach (['C1', 'C2'] as $kode) {
                $bobot = $bobots->firstWhere('kriteria.kode', $kode);
                $w = $bobot ? (float) $bobot->bobot : 0;
                $x = $row[$kode] ?? 0;
                $rnorm = $maxPerKriteria[$kode] ? $x / $maxPerKriteria[$kode] : 0;
                $kontrib = $rnorm * $w;
                $totalVi += $kontrib;
                $detail[$kode] = [
                    'x' => $x,
                    'rnorm' => round($rnorm, 4),
                    'w' => $w,
                    'kontrib' => round($kontrib, 4),
                ];
            }
            $hasil[] = [
                'siswa' => $metaSiswa[$siswaId],
                'total_vi' => round($totalVi, 4),
                'detail' => $detail,
                'jumlah_prestasi' => count($perSiswa[$siswaId]),
            ];
        }

        return collect($hasil)->sortByDesc('total_vi')->values();
    }
}
