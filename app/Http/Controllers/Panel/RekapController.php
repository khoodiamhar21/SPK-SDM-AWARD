<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\KategoriLomba;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();

        $kelasList = Kelas::orderBy('urutan')->get();
        $kategoriList = KategoriLomba::orderBy('nama')->get();
        $filterKelas = $request->query('kelas');
        $filterKategori = $request->query('kategori');
        $filterJenis = $request->query('jenis');
        $search = $request->query('search');

        $perKategori = collect();
        if ($periode) {
            $siswas = Siswa::whereHas('prestasis', function ($q) use ($periode, $filterJenis) {
                    $q->where('periode_id', $periode->id)
                        ->where('status_validasi', 'valid')
                        ->whereNotNull('nilai_rubrik');
                    if ($filterJenis) {
                        $q->where('jenis_prestasi', $filterJenis);
                    }
                })
                ->when($filterKelas, fn ($q) => $q->where('kelas_id', $filterKelas))
                ->when($search, fn ($q) => $q->where(function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                }))
                ->with(['prestasis' => function ($q) use ($periode, $filterJenis) {
                    $q->where('periode_id', $periode->id)
                        ->where('status_validasi', 'valid')
                        ->whereNotNull('nilai_rubrik');
                    if ($filterJenis) {
                        $q->where('jenis_prestasi', $filterJenis);
                    }
                    $q->orderByDesc('nilai_rubrik')
                        ->with('kategoriLomba');
                }])
                ->orderBy('nama')
                ->get();

            $kategoris = KategoriLomba::orderBy('nama')->get()
                ->when($filterKategori, fn ($q) => $q->where('id', (int) $filterKategori))
                ->when($filterJenis, fn ($q) => $q->where('jenis_prestasi', $filterJenis));

            $perKategori = $kategoris->map(function ($kategori) use ($siswas) {
                    $items = $siswas->filter(fn ($s) => $s->prestasis->contains(fn ($p) => $p->kategori_lomba_id === $kategori->id))
                        ->map(function ($s) use ($kategori) {
                            return [
                                'nama' => $s->nama,
                                'nisn' => $s->nisn,
                                'kelas' => $s->kelas?->nama ?? '-',
                                'prestasis' => $s->prestasis->where('kategori_lomba_id', $kategori->id)->values(),
                                'total' => $s->prestasis->where('kategori_lomba_id', $kategori->id)->sum('nilai_rubrik'),
                            ];
                        })->values();

                    return [
                        'id' => $kategori->id,
                        'nama' => $kategori->nama,
                        'jenis_prestasi' => $kategori->jenis_prestasi,
                        'jumlah' => $items->count(),
                        'items' => $items,
                    ];
                })
                ->filter(fn ($r) => $r['jumlah'] > 0)
                ->values();
        }

        return view('panel.rekap-index', compact('perKategori', 'periode', 'kelasList', 'kategoriList', 'filterKelas', 'filterKategori', 'filterJenis', 'search'));
    }
}