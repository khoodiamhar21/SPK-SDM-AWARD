<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();

        $kelasList = Kelas::orderBy('urutan')->get();
        $filterKelas = $request->query('kelas');

        $siswas = collect();
        if ($periode) {
            $siswas = Siswa::whereHas('prestasis', function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id)
                        ->where('status_validasi', 'valid')
                        ->whereNotNull('nilai_rubrik');
                })
                ->when($filterKelas, fn ($q) => $q->where('kelas_id', $filterKelas))
                ->with(['prestasis' => function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id)
                        ->where('status_validasi', 'valid')
                        ->whereNotNull('nilai_rubrik')
                        ->orderByDesc('nilai_rubrik');
                }])
                ->orderBy('nama')
                ->get();
        }

        return view('panel.rekap-index', compact('siswas', 'periode', 'kelasList', 'filterKelas'));
    }
}
