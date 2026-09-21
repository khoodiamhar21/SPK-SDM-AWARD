<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Berita;
use App\Models\Pengumuman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    // ===== BANNER =====
    public function bannerIndex()
    {
        $banners = Banner::orderBy('urutan')->get();
        return view('panel.banner-index', compact('banners'));
    }

    public function bannerStore(Request $request)
    {
        $data = $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'judul' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);
        $path = $request->file('foto')->store('banners', 'public');
        Banner::create(['foto_path' => $path, 'judul' => $data['judul'], 'urutan' => $data['urutan'] ?? 0]);

        return back()->with('status', 'Banner ditambahkan.');
    }

    public function bannerDestroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->foto_path);
        $banner->delete();
        return back()->with('status', 'Banner dihapus.');
    }

    // ===== BERITA =====
    public function beritaIndex()
    {
        $beritas = Berita::latest('tanggal')->get();
        return view('panel.berita-index', compact('beritas'));
    }

    public function beritaStore(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'isi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);
        $path = $request->hasFile('foto') ? $request->file('foto')->store('berita', 'public') : null;
        Berita::create(array_merge($data, ['foto_path' => $path]));

        return back()->with('status', 'Berita ditambahkan.');
    }

    public function beritaDestroy(Berita $berita)
    {
        if ($berita->foto_path) Storage::disk('public')->delete($berita->foto_path);
        $berita->delete();
        return back()->with('status', 'Berita dihapus.');
    }

    // ===== PENGUMUMAN =====
    public function pengumumanIndex()
    {
        $pengumumans = Pengumuman::latest('tanggal')->get();
        return view('panel.pengumuman-index', compact('pengumumans'));
    }

    public function pengumumanStore(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);
        Pengumuman::create($data);
        return back()->with('status', 'Pengumuman ditambahkan.');
    }

    public function pengumumanDestroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return back()->with('status', 'Pengumuman dihapus.');
    }

    private function susunDataPengumuman(Pengumuman $pengumuman, ?string $kategori = null): array
    {
        $data = collect($pengumuman->data ?? []);

        $kategoriList = $data->pluck('kategori')->filter()->unique()->sort()->values();

        $rows = $kategori
            ? $data->filter(fn ($r) => ($r['kategori'] ?? '-') === $kategori)
            : $data;

        $perKategori = $rows
            ->groupBy(fn ($r) => $r['kategori'] ?? '-')
            ->map(fn ($items) => $items->sortBy('peringkat')->values());

        $kriteriaKodes = $data
            ->pluck('detail')
            ->filter()
            ->flatMap(fn ($d) => collect($d)->keys())
            ->unique()
            ->sort()
            ->values();

        return [$perKategori, $kategoriList, $kriteriaKodes, $kategori];
    }

    public function pengumumanShow(Request $request, Pengumuman $pengumuman)
    {
        [$perKategori, $kategoriList, $kriteriaKodes] = $this->susunDataPengumuman(
            $pengumuman,
            $request->query('kategori')
        );

        return view('pengumuman-detail', compact(
            'pengumuman', 'perKategori', 'kategoriList', 'kriteriaKodes'
        ));
    }

    public function pengumumanPdf(Request $request, Pengumuman $pengumuman)
    {
        [$perKategori, $kategoriList, $kriteriaKodes, $kategoriAktif] = $this->susunDataPengumuman(
            $pengumuman,
            $request->query('kategori')
        );

        $pdf = Pdf::loadView('panel.pengumuman-pdf', compact(
            'pengumuman', 'perKategori', 'kategoriList', 'kriteriaKodes', 'kategoriAktif'
        ));

        $namaFile = 'pengumuman-'.$pengumuman->id.($kategoriAktif ? '-'.\Illuminate\Support\Str::slug($kategoriAktif) : '').'.pdf';

        return $pdf->download($namaFile);
    }
}
