<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
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
        $kelasId = $request->get('kelas_id');
        $search = $request->get('search');
        $query = Siswa::with('kelas')->withCount('prestasis');
        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }
        $siswas = $query->orderBy('nama')->get();
        $kelas = Kelas::orderBy('urutan')->get();

        return view('panel.siswa-index', compact('siswas', 'kelas', 'kelasId', 'search'));
    }

    public function create()
    {
        $siswa = null;
        $kelas = Kelas::orderBy('urutan')->get();

        return view('panel.siswa-form', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn' => 'nullable|string|max:30|unique:siswas,nisn',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string|max:500',
            'no_hp_ortu' => 'nullable|string|max:30',
        ]);
        Siswa::create($data);

        return redirect()->route('panel.siswa.index')->with('success', 'Data siswa disimpan.');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('urutan')->get();

        return view('panel.siswa-form', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nisn' => 'nullable|string|max:30|unique:siswas,nisn,'.$siswa->id,
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string|max:500',
            'no_hp_ortu' => 'nullable|string|max:30',
        ]);
        $siswa->update($data);

        return redirect()->route('panel.siswa.index')->with('success', 'Data siswa diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('panel.siswa.index')->with('success', 'Data siswa dihapus.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['prestasis' => fn ($q) => $q->with('periode')->latest()]);
        return view('panel.siswa-show', compact('siswa'));
    }

    public function naikKelasSiswa(Request $request)
    {
        $siswa = $request->user()->siswa;
        $periodeAktif = Periode::where('aktif', true)->first();

        if ($siswa) {
            $siswa->naikKelas();
            $siswa->update(['periode_terakhir_ikuti' => $periodeAktif?->id]);
        }

        return redirect()->back();
    }

    public function lewatiNaikKelas(Request $request)
    {
        $siswa = $request->user()->siswa;
        $periodeAktif = Periode::where('aktif', true)->first();

        if ($siswa && $periodeAktif) {
            $siswa->update(['periode_terakhir_ikuti' => $periodeAktif->id]);
        }

        return redirect()->back();
    }

    public function profilEdit(Request $request)
    {
        $user = $request->user();
        $siswa = $user->siswa;

        return view('siswa.profil', compact('user', 'siswa'));
    }

    public function profilUpdate(Request $request)
    {
        $user = $request->user();
        $siswa = $user->siswa;

        $validated = $request->validate([
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_hp_ortu' => ['nullable', 'string', 'max:30'],
        ]);

        if ($siswa) {
            if ($request->hasFile('foto')) {
                $request->validate(['foto' => 'image|mimes:jpg,jpeg,png,webp|max:2048']);
                $path = $request->file('foto')->store('foto-siswa', 'public');
                $siswa->update(['foto' => $path]);
            }

            $siswa->update($validated);
        }

        return redirect()->route('siswa.profil')->with('status', 'Data diri diperbarui.');
    }

    public function ranking(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();

        $kelasList = Kelas::orderBy('urutan')->get();
        $filterKelas = $request->query('kelas');

        $final = null;
        $riwayat = collect();
        if ($periode) {
            $final = Ranking::where('periode_id', $periode->id)->latest()->first();
            $riwayat = Ranking::where('periode_id', $periode->id)->latest()->get();
        }

        return view('panel.ranking', compact('periode', 'final', 'riwayat', 'kelasList', 'filterKelas'));
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
