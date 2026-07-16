<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Services\SawService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $periodeAktif = Periode::where('aktif', true)->first();

        if ($user->isSiswa()) {
            $siswa = $user->siswa;
            $prestasis = $siswa ? $siswa->prestasis()->with('periode')->latest()->get() : collect();
            return view('siswa.dashboard', compact('siswa', 'prestasis', 'periodeAktif'));
        }

        // panitia / waka
        $totalSiswa = Siswa::count();
        $totalPrestasi = Prestasi::count();
        $menunggu = Prestasi::where('status_validasi', 'menunggu')->count();
        $ranking = $periodeAktif ? (new SawService())->hitung($periodeAktif) : collect();

        return view('panel.dashboard', compact('totalSiswa', 'totalPrestasi', 'menunggu', 'ranking', 'periodeAktif'));
    }
}
