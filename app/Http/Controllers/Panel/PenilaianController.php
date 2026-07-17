<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Rubrik;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
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

        return redirect()->route('panel.penilaian.index')
            ->with('status', 'Nilai prestasi disimpan.');
    }
}
