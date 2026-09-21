<?php

namespace App\Http\Controllers;

use App\Models\KategoriLomba;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Tingkat;
use App\Services\SawService;
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

        // Rekap posisi siswa per kategori (live/perhitungan terbaru)
        $posisiKategori = $siswa
            ? $ranking->filter(fn ($r) => $r['siswa']->id === $siswa->id)
                ->sortBy('peringkat')->values()
            : collect();
        $peringkat = $posisiKategori->first()['peringkat'] ?? null;
        $nilai = $posisiKategori->first()['total_vi'] ?? null;

        // Jika ranking sudah dihitung & divalidasi, posisi menjadi nilai perolehan (final)
        $rankingValid = \App\Services\SawService::rankingTervalidasi($periodeAktif);
        $posisiFinal = collect();
        if ($siswa && $rankingValid) {
            $posisiFinal = \App\Services\SawService::entriSiswa($rankingValid, $siswa->id)
                ->keyBy('kategori_lomba_id');
        }

        return view('siswa.status-seleksi', compact(
            'prestasis', 'periodeAktif', 'peringkat', 'nilai',
            'ranking', 'posisiKategori', 'posisiFinal'
        ));
    }

    public function create(Request $request)
    {
        $siswa = $request->user()->siswa;
        $periodes = Periode::where('aktif', true)->get();
        $prestasi = null;
        $tingkats = Tingkat::orderBy('urutan')->get();
        $kategoris = KategoriLomba::orderBy('nama')->get();

        return view('siswa.prestasi-form', compact('siswa', 'periodes', 'prestasi', 'tingkats', 'kategoris'));
    }

    public function store(Request $request)
    {
        $siswa = $request->user()->siswa;

        $data = $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_prestasi' => 'required|in:akademik,non_akademik',
            'kategori_lomba_id' => 'required|exists:kategori_lombas,id',
            'tingkat' => 'required|in:kabupaten,provinsi,nasional,internasional',
            'peringkat' => 'required|in:juara1,juara2,juara3',
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
            'kategori_lomba_id' => $data['kategori_lomba_id'],
            'jenis_prestasi' => $data['jenis_prestasi'],
            'tingkat' => $data['tingkat'],
            'peringkat' => $data['peringkat'],
            'jenis' => $data['jenis'],
            'tanggal' => $data['tanggal'],
            'sertifikat_path' => $path,
            'catatan' => $data['catatan'] ?? null,
            'status_validasi' => 'menunggu',
        ]);
        SawService::flushCache((int) $data['periode_id']);

        return redirect()->route('prestasi.index')->with('status', 'Data prestasi dikirim, menunggu validasi panitia.');
    }

    public function validasi(Request $request, Prestasi $prestasi)
    {
        $data = $request->validate([
            'status_validasi' => 'required|in:valid,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $prestasi->update($data);

        if ($data['status_validasi'] !== 'valid') {
            $prestasi->nilai_rubrik = null;
            $prestasi->save();
        }
        SawService::flushCache($prestasi->periode_id);

        return back()->with('status', 'Status prestasi diperbarui.');
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa', 'periode', 'kategoriLomba']);

        // Nilai rubrik otomatis berdasarkan kombinasi kriteria
        $skorRubrik = \App\Models\Rubrik::cariSkor(
            $prestasi->kategori_lomba_id,
            $prestasi->peringkat,
            $prestasi->jenis,
            $prestasi->tingkat
        );

        return view('panel.prestasi-show', compact('prestasi', 'skorRubrik'));
    }

    public function edit(Request $request, Prestasi $prestasi)
    {
        $siswa = $request->user()->siswa;

        if ($prestasi->siswa_id !== $siswa?->id) {
            abort(403);
        }

        if ($prestasi->status_validasi !== 'menunggu') {
            return back()->withErrors(['msg' => 'Prestasi sudah divalidasi, tidak bisa diedit.']);
        }

        $periodes = Periode::where('aktif', true)->get();
        $tingkats = Tingkat::orderBy('urutan')->get();
        $kategoris = KategoriLomba::orderBy('nama')->get();

        return view('siswa.prestasi-form', compact('siswa', 'periodes', 'prestasi', 'tingkats', 'kategoris'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $siswa = $request->user()->siswa;

        if ($prestasi->siswa_id !== $siswa?->id) {
            abort(403);
        }

        if ($prestasi->status_validasi !== 'menunggu') {
            return back()->withErrors(['msg' => 'Prestasi sudah divalidasi, tidak bisa diedit.']);
        }

        $data = $request->validate([
            'periode_id' => 'required|exists:periodes,id',
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_prestasi' => 'required|in:akademik,non_akademik',
            'kategori_lomba_id' => 'required|exists:kategori_lombas,id',
            'tingkat' => 'required|in:kabupaten,provinsi,nasional,internasional',
            'peringkat' => 'required|in:juara1,juara2,juara3',
            'jenis' => 'required|in:perorangan,beregu',
            'tanggal' => 'required|date',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $periode = Periode::findOrFail($data['periode_id']);
        if ($periode->tahun != substr($data['tanggal'], 0, 4)) {
            return back()->withErrors(['tanggal' => 'Tanggal sertifikat harus dalam tahun periode '.$periode->tahun.'.']);
        }

        if ($request->hasFile('sertifikat')) {
            if ($prestasi->sertifikat_path) {
                Storage::disk('local')->delete($prestasi->sertifikat_path);
            }
            $data['sertifikat_path'] = $request->file('sertifikat')->store('sertifikat', 'local');
        }

        $periodeLama = $prestasi->periode_id;
        $prestasi->update($data);
        SawService::flushCache($periodeLama);
        SawService::flushCache((int) $data['periode_id']);

        return redirect()->route('prestasi.status')->with('status', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Request $request, Prestasi $prestasi)
    {
        $siswa = $request->user()->siswa;

        if ($prestasi->siswa_id !== $siswa?->id) {
            abort(403);
        }

        if ($prestasi->status_validasi !== 'menunggu') {
            return back()->withErrors(['msg' => 'Prestasi sudah divalidasi, tidak bisa dihapus.']);
        }

        if ($prestasi->sertifikat_path) {
            Storage::disk('local')->delete($prestasi->sertifikat_path);
        }

        $periodeId = $prestasi->periode_id;
        $prestasi->delete();
        SawService::flushCache((int) $periodeId);

        return redirect()->route('prestasi.status')->with('status', 'Prestasi berhasil dihapus.');
    }

    public function dokumen(Prestasi $prestasi)
    {
        if (! $prestasi->sertifikat_path || ! Storage::disk('local')->exists($prestasi->sertifikat_path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($prestasi->sertifikat_path));
    }
}
