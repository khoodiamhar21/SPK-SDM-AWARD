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
            $nilaiSementara = ($siswa && $periodeAktif)
                ? (new SawService())->hitungSiswa($periodeAktif, $siswa)
                : null;
            return view('siswa.dashboard', compact('siswa', 'prestasis', 'periodeAktif', 'nilaiSementara'));
        }

        // panitia / waka
        $totalSiswa = Siswa::count();
        $totalPrestasi = Prestasi::count();
        $menunggu = Prestasi::where('status_validasi', 'menunggu')->count();
        $ranking = $periodeAktif ? (new SawService())->hitung($periodeAktif) : collect();
        $sudahDinilaiIds = $ranking->pluck('siswa_id')->all();

        $siswaList = Siswa::with(['user', 'prestasis' => function ($q) use ($periodeAktif) {
                if ($periodeAktif) {
                    $q->where('periode_id', $periodeAktif->id);
                }
            }])
            ->when($periodeAktif, fn ($q) => $q->whereHas('prestasis', fn ($p) => $p->where('periode_id', $periodeAktif->id)))
            ->orderBy('nama')
            ->get()
            ->map(function ($s) use ($sudahDinilaiIds) {
                $valid = $s->prestasis->where('status_validasi', 'valid')->count();
                $menunggu = $s->prestasis->where('status_validasi', 'menunggu')->count();
                $ditolak = $s->prestasis->where('status_validasi', 'ditolak')->count();

                if ($valid > 0 && $menunggu === 0 && $ditolak === 0) {
                    $status = in_array($s->id, $sudahDinilaiIds) ? 'sudah_dinilai' : 'sudah_validasi';
                } elseif ($menunggu > 0) {
                    $status = 'menunggu';
                } elseif ($ditolak > 0 && $valid === 0) {
                    $status = 'ditolak';
                } elseif ($valid > 0) {
                    $status = in_array($s->id, $sudahDinilaiIds) ? 'sudah_dinilai' : 'sudah_validasi';
                } else {
                    $status = 'menunggu';
                }

                return (object) [
                    'id' => $s->id,
                    'nama' => $s->nama,
                    'nisn' => $s->nisn,
                    'status' => $status,
                ];
            });

        return view('panel.dashboard', compact('totalSiswa', 'totalPrestasi', 'menunggu', 'ranking', 'periodeAktif', 'siswaList'));
    }
}
