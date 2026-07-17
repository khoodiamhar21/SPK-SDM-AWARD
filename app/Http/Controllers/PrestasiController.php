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
        if ($request->user()->isSiswa()) {
            return $this->statusSeleksi($request);
        }

        $periodeId = $request->get('periode_id');
        $query = Prestasi::with(['siswa', 'periode'])->latest();

        if ($periodeId) {
            $query->where('periode_id', $periodeId);
        }

        $prestasis = $query->paginate(15);
        $periodes = Periode::orderByDesc('tahun')->get();

        return view('panel.prestasi-index', compact('prestasis', 'periodes', 'periodeId'));
    }

    public function statusSeleksi(Request $request)
    {
        $siswa = $request->user()->siswa;
        $periodeAktif = Periode::where('aktif', true)->first();
        $prestasis = $siswa
            ? $siswa->prestasis()->with('periode')->latest()->get()
            : collect();

        $ranking = $periodeAktif ? (new \App\Services\SawService())->hitung($periodeAktif) : collect();
        $posisi = $ranking->firstWhere('siswa.id', $siswa?->id);
        $peringkat = $posisi ? $posisi['peringkat'] : null;
        $nilai = $posisi ? $posisi['total_vi'] : null;

        return view('siswa.status-seleksi', compact('prestasis', 'periodeAktif', 'peringkat', 'nilai', 'ranking'));
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
            'tingkat' => 'required|in:kabupaten,provinsi,nasional,internasional',
            'peringkat' => 'required|in:juara1,juara2,juara3',
            'penyelenggara' => 'required|in:pemerintah,swasta',
            'jenis' => 'required|in:perorangan,beregu',
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
            'penyelenggara' => $data['penyelenggara'],
            'jenis' => $data['jenis'],
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

        if ($data['status_validasi'] === 'valid') {
            $prestasi->isiNilaiRubrik();
        } else {
            $prestasi->nilai_rubrik = null;
            $prestasi->save();
        }

        return back()->with('status', 'Status prestasi diperbarui.');
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa', 'periode']);

        // Nilai rubrik otomatis berdasarkan kombinasi kriteria
        $skorRubrik = \App\Models\Rubrik::cariSkor(
            $prestasi->penyelenggara,
            $prestasi->peringkat,
            $prestasi->jenis,
            $prestasi->tingkat
        );

        return view('panel.prestasi-show', compact('prestasi', 'skorRubrik'));
    }

    public function dokumen(Prestasi $prestasi)
    {
        if (! $prestasi->sertifikat_path || ! Storage::disk('local')->exists($prestasi->sertifikat_path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($prestasi->sertifikat_path));
    }
}
