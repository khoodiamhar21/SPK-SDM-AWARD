<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Detail Penilaian: {{ $prestasi->nama_kegiatan }}</h1>
        <a href="{{ route('panel.penilaian.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Data Prestasi</h3>
            <dl class="text-sm space-y-3">
                <div><dt class="text-slate-400">Siswa</dt><dd class="font-semibold">{{ $prestasi->siswa->nama ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Kegiatan</dt><dd class="font-semibold">{{ $prestasi->nama_kegiatan }}</dd></div>
                <div><dt class="text-slate-400">Kategori Lomba</dt><dd class="font-semibold capitalize">{{ $prestasi->kategoriLomba?->nama ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Jenis</dt><dd class="font-semibold capitalize">{{ $prestasi->jenis }}</dd></div>
                <div><dt class="text-slate-400">Tingkat</dt><dd class="font-semibold capitalize">{{ $prestasi->tingkat }}</dd></div>
                <div><dt class="text-slate-400">Peringkat</dt><dd class="font-semibold">{{ str_replace('juara','Juara ',$prestasi->peringkat) }}</dd></div>
                <div><dt class="text-slate-400">Tanggal</dt><dd class="font-semibold">{{ $prestasi->tanggal->format('d M Y') }}</dd></div>
            </dl>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <h3 class="font-semibold text-slate-700 mb-4">Nilai Penilaian</h3>
                <div class="rounded-xl bg-gradient-to-br from-emerald-600 to-teal-500 text-white p-6 text-center">
                    <div class="text-xs text-emerald-50">Nilai Rubrik (otomatis)</div>
                    <div class="text-4xl font-bold mt-1">{{ $prestasi->nilai_rubrik ?? '—' }}</div>
                    <div class="text-[11px] text-emerald-50/90 mt-2">Dari tabel rubrik berdasarkan kategori, tingkat & peringkat</div>
                </div>
                @if($prestasi->catatan)
                    <div class="mt-4 text-sm text-slate-500"><b>Catatan:</b> {{ $prestasi->catatan }}</div>
                @endif
            </div>

            @if($prestasi->sertifikat_path)
                <div class="bg-white rounded-2xl shadow-sm border p-6">
                    <h3 class="font-semibold text-slate-700 mb-4">Berkas Sertifikat</h3>
                    <a href="{{ route('panel.prestasi.dokumen', $prestasi) }}" target="_blank" class="inline-block px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-sm font-medium mb-3">Buka / Unduh</a>
                    <iframe src="{{ route('panel.prestasi.dokumen', $prestasi) }}" class="w-full h-[360px] rounded-lg border"></iframe>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
