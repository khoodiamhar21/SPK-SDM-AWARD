<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Ranking;
use App\Models\Siswa;
use App\Services\SawService;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $siswas = Siswa::withCount('prestasis')->orderBy('nama')->get();
        return view('panel.siswa-index', compact('siswas'));
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['prestasis' => fn ($q) => $q->with('periode')->latest()]);
        return view('panel.siswa-show', compact('siswa'));
    }

    public function ranking(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();

        $final = null;
        $riwayat = collect();
        if ($periode) {
            $final = Ranking::where('periode_id', $periode->id)->latest()->first();
            $riwayat = Ranking::where('periode_id', $periode->id)->latest()->get();
        }

        return view('panel.ranking', compact('periode', 'final', 'riwayat'));
    }

    public function generateRanking(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();

        if (! $periode) {
            return back()->withErrors(['msg' => 'Tidak ada periode aktif.']);
        }

        $belumDinilai = Prestasi::where('periode_id', $periode->id)
            ->where('status_validasi', 'valid')
            ->whereNull('nilai_rubrik')
            ->count();

        if ($belumDinilai > 0) {
            return back()->withErrors(['msg' => "Masih ada {$belumDinilai} prestasi yang belum dinilai. Selesaikan penilaian terlebih dahulu."]);
        }

        $hasil = (new SawService())->hitung($periode)->map(function ($item) {
            return [
                'siswa_id' => $item['siswa']->id,
                'nama' => $item['siswa']->nama,
                'kelas' => $item['siswa']->kelas,
                'total_vi' => $item['total_vi'],
                'nilai_akhir' => $item['nilai_akhir'],
                'detail' => $item['detail'],
                'peringkat' => $item['peringkat'],
                'jumlah_prestasi' => $item['jumlah_prestasi'],
            ];
        })->values()->toArray();

        Ranking::create([
            'periode_id' => $periode->id,
            'panitia_id' => $request->user()->id,
            'hasil' => $hasil,
        ]);

        return redirect()->route('panel.ranking')->with('status', 'Ranking berhasil di-generate.');
    }

    public function setujuiRanking(Request $request, Ranking $ranking)
    {
        if ($ranking->disetujui_at) {
            return back()->withErrors(['msg' => 'Ranking sudah disetujui.']);
        }

        $ranking->update([
            'disetujui_oleh' => $request->user()->id,
            'disetujui_at' => now(),
        ]);

        return back()->with('status', 'Hasil ranking disetujui oleh Waka Kesiswaan.');
    }

    public function umumkanHasil(Request $request, Ranking $ranking)
    {
        if (! $ranking->disetujui_at) {
            return back()->withErrors(['msg' => 'Ranking harus disetujui Waka terlebih dahulu.']);
        }

        if ($ranking->diumumkan_at) {
            return back()->withErrors(['msg' => 'Hasil sudah diumumkan.']);
        }

        $daftar = collect($ranking->hasil)
            ->sortBy('peringkat')
            ->map(fn ($r) => "{$r['peringkat']}. {$r['nama']} (Kelas {$r['kelas']}) — Nilai Akhir ".number_format($r['nilai_akhir'] ?? $r['total_vi'], 2))
            ->implode("\n");

        $pengumuman = \App\Models\Pengumuman::create([
            'judul' => 'Pengumuman Hasil SDM Award '.$ranking->periode->nama,
            'tanggal' => now(),
            'isi' => "Berikut adalah siswa berprestasi terpilih:\n\n".$daftar,
        ]);

        $ranking->update(['diumumkan_at' => now()]);

        return redirect()->route('panel.ranking')->with('status', 'Hasil seleksi diumumkan.');
    }
}
