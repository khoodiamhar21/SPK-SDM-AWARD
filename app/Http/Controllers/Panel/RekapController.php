<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index()
    {
        $periode = Periode::where('aktif', true)->first();

        $siswas = collect();
        if ($periode) {
            $siswas = Siswa::whereHas('prestasis', function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id)
                        ->where('status_validasi', 'valid')
                        ->whereNotNull('nilai_rubrik');
                })
                ->with(['prestasis' => function ($q) use ($periode) {
                    $q->where('periode_id', $periode->id)
                        ->where('status_validasi', 'valid')
                        ->whereNotNull('nilai_rubrik')
                        ->orderByDesc('nilai_rubrik');
                }])
                ->orderBy('nama')
                ->get();
        }

        return view('panel.rekap-index', compact('siswas', 'periode'));
    }
}
