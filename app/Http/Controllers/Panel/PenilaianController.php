<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Rubrik;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    // PENILAIAN BERJENJANG: Kelas -> Siswa -> Prestasi
    public function kelas()
    {
        $periode = Periode::where('aktif', true)->first();
        $kelas = Kelas::whereHas('siswas', fn ($q) => $q->whereHas('prestasis', fn ($q2) => $q2
            ->where('periode_id', $periode?->id)
            ->where('status_validasi', 'valid')))
            ->orderBy('urutan')->get();
        $kelas->loadCount(['siswas' => fn ($q) => $q->whereHas('prestasis', fn ($q2) => $q2
            ->where('periode_id', $periode?->id)
            ->where('status_validasi', 'valid'))]);

        return view('panel.penilaian-kelas', compact('kelas', 'periode'));
    }

    public function siswa(Kelas $kelas)
    {
        $periode = Periode::where('aktif', true)->first();
        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->whereHas('prestasis', fn ($q) => $q->where('periode_id', $periode?->id)->where('status_validasi', 'valid'))
            ->orderBy('nama')->get();

        return view('panel.penilaian-siswa', compact('kelas', 'siswas', 'periode'));
    }

    public function prestasi(Siswa $siswa)
    {
        $periode = Periode::where('aktif', true)->first();
        $prestasis = $siswa->prestasis()->where('periode_id', $periode?->id)
            ->where('status_validasi', 'valid')->latest()->get();

        return view('panel.penilaian-prestasi', compact('siswa', 'prestasis', 'periode'));
    }

    public function index(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();

        // Hanya prestasi yang sudah lolos validasi berkas
        $query = Prestasi::with(['siswa', 'periode'])
            ->when($periode, fn ($q) => $q->where('periode_id', $periode->id))
            ->where('status_validasi', 'valid')
            ->latest();

        $prestasis = $query->paginate(12)->withQueryString();

        // Progress: siswa yg sudah punya semua prestasi dinilai
        $belumDinilai = Prestasi::where('status_validasi', 'valid')
            ->when($periode, fn ($q) => $q->where('periode_id', $periode->id))
            ->whereNull('nilai_rubrik')
            ->count();

        return view('panel.penilaian-index', compact('prestasis', 'periode', 'belumDinilai'));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa', 'periode']);

        $skorRekomendasi = Rubrik::cariSkor(
            $prestasi->penyelenggara,
            $prestasi->peringkat,
            $prestasi->jenis,
            $prestasi->tingkat
        );

        return view('panel.penilaian-show', compact('prestasi', 'skorRekomendasi'));
    }

    public function nilai(Request $request, Prestasi $prestasi)
    {
        $data = $request->validate([
            'nilai_rubrik' => 'required|numeric|min:40|max:100',
            'catatan' => 'nullable|string',
        ]);

        $prestasi->update([
            'nilai_rubrik' => $data['nilai_rubrik'],
            'catatan' => $data['catatan'] ?? $prestasi->catatan,
        ]);

        return redirect()->route('panel.penilaian.prestasi', $prestasi->siswa)
            ->with('status', 'Nilai prestasi disimpan.');
    }
}
