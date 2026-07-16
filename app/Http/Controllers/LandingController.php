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
        $ranking = $periode ? (new SawService())->hitung($periode)->take(4) : collect();

        $berita = [
            ['tanggal' => 'Senin, 20 Jan 2025', 'judul' => 'Juara I Lomba Baca Puisi SD/Sederajat Tingkat Provinsi', 'kategori' => 'Prestasi', 'foto' => 'img/amel.jpg'],
            ['tanggal' => 'Sabtu, 26 Des 2024', 'judul' => 'Juara II Lomba Da\'i Cilik SD/MI Tingkat Nasional', 'kategori' => 'Prestasi', 'foto' => 'img/logosd.png'],
            ['tanggal' => 'Sabtu, 30 Nov 2024', 'judul' => 'Penjaringan Peserta Didik Baru (PPDB) 2024/2025 Dibuka', 'kategori' => 'Informasi', 'foto' => 'img/029-trophy.png'],
            ['tanggal' => 'Senin, 16 Des 2024', 'judul' => 'Pelaksanaan Penilaian Akhir Semester 1 (PAS)', 'kategori' => 'Pengumuman', 'foto' => 'img/016-examination.png'],
        ];

        $prestasiSiswa = [
            ['nama' => 'Amirah Amelia', 'kelas' => 'V', 'prestasi' => 'Juara II Da\'i Cilik Tingkat Nasional', 'foto' => 'img/amel.jpg'],
            ['nama' => 'Ananda Kelas V', 'kelas' => 'V', 'prestasi' => 'Juara I Lomba Baca Puisi Tingkat Provinsi', 'foto' => 'img/logosd.png'],
            ['nama' => 'Tim LKBB', 'kelas' => '-', 'prestasi' => 'Juara Umum Lomba LKBB AGRAHA Kota Metro', 'foto' => 'img/029-trophy.png'],
        ];

        return view('landing', compact('periode', 'ranking', 'berita', 'prestasiSiswa'));
    }
}
