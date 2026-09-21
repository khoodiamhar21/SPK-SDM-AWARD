<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Services\SawService;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $periodes = Periode::orderByDesc('tahun')->get();
        $kriterias = Kriteria::with('bobots')->get();

        return view('panel.kriteria-index', compact('periodes', 'kriterias'));
    }

    public function updateBobot(Request $request)
    {
        $data = $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'bobot' => 'required|array',
            'bobot.*' => 'required|numeric|min:0|max:1',
        ]);

        $total = array_sum($data['bobot']);
        if (abs($total - 1) > 0.001) {
            return back()->withErrors(['bobot' => 'Total bobot harus = 1 (sekarang '.$total.').']);
        }

        foreach ($data['bobot'] as $kriteriaId => $bobot) {
            Bobot::updateOrCreate(
                ['kriteria_id' => $kriteriaId, 'periode_id' => $data['periode_id']],
                ['bobot' => $bobot]
            );
        }

        $this->log('update_bobot', "Update bobot kriteria periode #{$data['periode_id']}");
        SawService::flushCache((int) $data['periode_id']);

        return back()->with('status', 'Bobot kriteria disimpan.');
    }
}
