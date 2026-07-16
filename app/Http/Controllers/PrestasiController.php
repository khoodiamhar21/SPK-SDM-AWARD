<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $periodeId = $request->get('periode_id');
        $query = Prestasi::with(['siswa', 'periode'])->latest();

        if ($request->user()->isSiswa()) {
            $siswa = $request->user()->siswa;
            $query->where('siswa_id', $siswa?->id);
        } elseif ($periodeId) {
            $query->where('periode_id', $periodeId);
        }

        $prestasis = $query->paginate(15);
        $periodes = Periode::orderByDesc('tahun')->get();

        return view('panel.prestasi-index', compact('prestasis', 'periodes', 'periodeId'));
    }

    public function create(Request $request)
    {
        $siswa = $request->user()->siswa;
        $periodes = Periode::where('aktif', true)->get();

        return view('siswa.prestasi-form', compact('siswa', 'periodes'));
    }

    public function store(Request $request)
    {
        $siswa = $request->user()->siswa;

        $data = $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'nama_kegiatan' => 'required|string|max:255',
            'tingkat' => 'required|in:kota,provinsi,nasional,internasional',
            'peringkat' => 'required|in:juara1,juara2,juara3',
            'tanggal' => 'required|date',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string',
        ]);

        if (! $siswa) {
            return back()->withErrors(['msg' => 'Profil siswa belum lengkap. Hubungi panitia.']);
        }

        // Filter periode: hanya sertifikat dalam tahun periode
        $periode = Periode::findOrFail($data['periode_id']);
        if ($periode->tahun != substr($data['tanggal'], 0, 4)) {
            return back()->withErrors(['tanggal' => 'Tanggal sertifikat harus dalam tahun periode '.$periode->tahun.'.']);
        }

        $path = null;
        if ($request->hasFile('sertifikat')) {
            $path = $request->file('sertifikat')->store('sertifikat', 'local');
        }

        $siswa->prestasis()->create([
            'periode_id' => $data['periode_id'],
            'nama_kegiatan' => $data['nama_kegiatan'],
            'tingkat' => $data['tingkat'],
            'peringkat' => $data['peringkat'],
            'tanggal' => $data['tanggal'],
            'sertifikat_path' => $path,
            'catatan' => $data['catatan'] ?? null,
            'status_validasi' => 'menunggu',
        ]);

        return redirect()->route('prestasi.index')->with('status', 'Data prestasi dikirim, menunggu validasi panitia.');
    }

    public function validasi(Request $request, Prestasi $prestasi)
    {
        $data = $request->validate([
            'status_validasi' => 'required|in:valid,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $prestasi->update($data);

        return back()->with('status', 'Status prestasi diperbarui.');
    }
}
