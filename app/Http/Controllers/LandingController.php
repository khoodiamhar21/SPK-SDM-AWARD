<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Services\SawService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();
        $ranking = $periode ? (new SawService())->hitung($periode)->take(4) : collect();

        $banners = Banner::where('aktif', true)->orderBy('urutan')->get();
        $beritas = Berita::latest('tanggal')->take(4)->get();
        $pengumumans = Pengumuman::latest('tanggal')->take(5)->get();

        $prestasiSiswa = collect([
            ['nama' => 'Amirah Amelia', 'kelas' => 'V', 'prestasi' => 'Juara II Da\'i Cilik Tingkat Nasional', 'foto' => 'img/amel.jpg'],
            ['nama' => 'Ananda Kelas V', 'kelas' => 'V', 'prestasi' => 'Juara I Lomba Baca Puisi Tingkat Provinsi', 'foto' => 'img/logosd.png'],
            ['nama' => 'Tim LKBB', 'kelas' => '-', 'prestasi' => 'Juara Umum Lomba LKBB AGRAHA Kota Metro', 'foto' => 'img/029-trophy.png'],
            ['nama' => 'Salsabila', 'kelas' => 'IV', 'prestasi' => 'Juara I MTQ Tingkat Kota Metro', 'foto' => 'img/5aa.jpg'],
            ['nama' => 'Dimas P.', 'kelas' => 'VI', 'prestasi' => 'Juara II Olimpiade Sains Tingkat Provinsi', 'foto' => 'img/2aa.jpg'],
        ]);

        $prestasiTerbaru = Prestasi::with('siswa')
            ->where('status_validasi', 'valid')
            ->when($periode, fn ($q) => $q->where('periode_id', $periode->id))
            ->latest('tanggal')
            ->take(6)
            ->get();

        return view('landing', compact('periode', 'ranking', 'banners', 'beritas', 'pengumumans', 'prestasiSiswa', 'prestasiTerbaru'));
    }
}
