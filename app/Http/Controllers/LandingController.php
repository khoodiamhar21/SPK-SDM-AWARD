<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Services\SawService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();
        $ranking = $periode ? (new SawService())->hitung($periode)->take(5) : collect();

        return view('landing', compact('periode', 'ranking'));
    }
}
