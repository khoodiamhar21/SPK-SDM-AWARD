<?php

namespace App\Services;

use App\Models\Bobot;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Ranking;
use App\Models\Siswa;
use App\Models\Tingkat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SawService
{
    public static function cacheKey(int $periodeId): string
    {
        return "saw_hasil_periode_{$periodeId}";
    }

    public static function flushCache(?int $periodeId = null): void
    {
        if ($periodeId !== null) {
            Cache::forget(self::cacheKey($periodeId));

            return;
        }

        Periode::pluck('id')->each(fn ($id) => Cache::forget(self::cacheKey($id)));
    }

    public static function semuaKategoriDisetujui(Ranking $ranking): bool
    {
        $ids = collect($ranking->hasil)->pluck('kategori_lomba_id')->unique()->filter()->values()->all();
        if ($ids === []) {
            return false;
        }

        return is_array($ranking->disetujui_kelas) && ! array_diff($ids, $ranking->disetujui_kelas);
    }

    public static function sudahTervalidasi(?Ranking $ranking): bool
    {
        return $ranking !== null && ($ranking->disetujui_at || self::semuaKategoriDisetujui($ranking));
    }

    public static function rankingTervalidasi(?Periode $periode): ?Ranking
    {
        if (! $periode) {
            return null;
        }

        return Ranking::where('periode_id', $periode->id)
            ->latest()
            ->get()
            ->first(fn (Ranking $r) => self::sudahTervalidasi($r));
    }

    public static function entriSiswa(Ranking $ranking, int $siswaId): Collection
    {
        return collect($ranking->hasil)
            ->filter(fn ($r) => (int) ($r['siswa_id'] ?? 0) === $siswaId)
            ->sortBy('peringkat')
            ->values();
    }

    public function hitung(Periode $periode): Collection
    {
        return Cache::remember(
            self::cacheKey($periode->id),
            now()->addMinutes(5),
            fn () => $this->doHitung($periode)
        );
    }

    protected function doHitung(Periode $periode): Collection
    {
        $prestasis = Prestasi::with('siswa.kelas', 'kategoriLomba')
            ->where('periode_id', $periode->id)
            ->where('status_validasi', 'valid')
            ->whereNotNull('nilai_rubrik')
            ->whereNotNull('kategori_lomba_id')
            ->get();

        $tingkats = Tingkat::with('kriteria')->orderBy('urutan')->get();
        $tingkatMap = $tingkats->pluck('kriteria.kode', 'kode');
        $kriteriaKodes = $tingkats->pluck('kriteria.kode')->unique()->sort()->values()->toArray();

        $bobotMap = Bobot::where('periode_id', $periode->id)
            ->with('kriteria')
            ->get()
            ->keyBy(fn ($b) => $b->kriteria->kode);

        $perKategori = $prestasis->groupBy('kategori_lomba_id');

        $hasil = collect();

        foreach ($perKategori as $kategoriId => $items) {
            $kategoriNama = $items->first()->kategoriLomba?->nama ?? 'Tanpa Kategori';
            $perSiswa = $items->groupBy('siswa_id');

            $matriksX = [];
            $metaSiswa = [];
            foreach ($perSiswa as $siswaId => $itemSiswa) {
                $siswa = $itemSiswa->first()->siswa;
                $metaSiswa[$siswaId] = $siswa;
                $row = ['kelas_id' => $siswa?->kelas_id];
                foreach ($kriteriaKodes as $kode) {
                    $row[$kode] = 0;
                }
                foreach ($itemSiswa as $p) {
                    $kode = $tingkatMap[$p->tingkat] ?? null;
                    if (! $kode) {
                        continue;
                    }
                    $row[$kode] += (float) ($p->nilai_rubrik ?? 0);
                }
                $matriksX[$siswaId] = $row;
            }

            $maxPerKriteria = [];
            foreach ($kriteriaKodes as $kode) {
                $maxPerKriteria[$kode] = collect($matriksX)->max(fn ($r) => $r[$kode] ?? 0) ?: 1;
            }

            $hasilKategori = [];
            foreach ($matriksX as $siswaId => $row) {
                $totalVi = 0;
                $detail = [];
                foreach ($kriteriaKodes as $kode) {
                    $bobot = isset($bobotMap[$kode]) ? (float) $bobotMap[$kode]->bobot : 0;
                    $x = $row[$kode] ?? 0;
                    $rnorm = $maxPerKriteria[$kode] ? $x / $maxPerKriteria[$kode] : 0;
                    $kontrib = $rnorm * $bobot;
                    $totalVi += $kontrib;
                    $detail[$kode] = [
                        'x' => round($x, 2),
                        'rnorm' => round($rnorm, 4),
                        'w' => $bobot,
                        'kontrib' => round($kontrib, 4),
                    ];
                }

                $hasilKategori[] = [
                    'siswa' => $metaSiswa[$siswaId],
                    'kelas_id' => $row['kelas_id'],
                    'kategori_lomba_id' => (int) $kategoriId,
                    'kategori' => $kategoriNama,
                    'jenis_prestasi' => $items->first()->kategoriLomba?->jenis_prestasi ?? 'non_akademik',
                    'total_vi' => round($totalVi, 4),
                    'nilai_akhir' => round($totalVi, 4),
                    'detail' => $detail,
                    'jumlah_prestasi' => count($perSiswa[$siswaId]),
                ];
            }

            $hasilKategori = collect($hasilKategori)->sortByDesc('total_vi')->values();

            $hasilKategori->transform(function ($item, $i) {
                $item['peringkat'] = $i + 1;
                return $item;
            });

            $hasil = $hasil->concat($hasilKategori);
        }

        return $hasil->sortBy([
            ['kategori', 'asc'],
            ['peringkat', 'asc'],
        ])->values();
    }

    public function hitungSiswa(Periode $periode, Siswa $siswa): ?array
    {
        $ranking = $this->hitung($periode);
        $items = $ranking->where('siswa.id', $siswa->id)->values();

        if ($items->isEmpty()) {
            return null;
        }

        $terbaik = $items->sortBy('peringkat')->first();

        return [
            'kategori' => $terbaik['kategori'],
            'total_vi' => $terbaik['total_vi'],
            'nilai_akhir' => $terbaik['nilai_akhir'],
            'peringkat' => $terbaik['peringkat'],
            'jumlah_prestasi' => $terbaik['jumlah_prestasi'],
        ];
    }
}