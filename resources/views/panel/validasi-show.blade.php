<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Periksa Berkas: {{ $prestasi->nama_kegiatan }}</h1>
        <a href="{{ route('panel.validasi.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-blue-50 text-blue-800 text-sm border border-blue-200">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Data Prestasi</h3>
            <dl class="text-sm space-y-3">
                <div><dt class="text-slate-400">Siswa</dt><dd class="font-semibold">{{ $prestasi->siswa->nama ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Kegiatan</dt><dd class="font-semibold">{{ $prestasi->nama_kegiatan }}</dd></div>
                <div><dt class="text-slate-400">Tingkat</dt><dd class="font-semibold capitalize">{{ $prestasi->tingkat }}</dd></div>
                <div><dt class="text-slate-400">Peringkat</dt><dd class="font-semibold">{{ str_replace('juara','Juara ',$prestasi->peringkat) }}</dd></div>
                <div><dt class="text-slate-400">Penyelenggara</dt><dd class="font-semibold capitalize">{{ $prestasi->penyelenggara }}</dd></div>
                <div><dt class="text-slate-400">Jenis</dt><dd class="font-semibold capitalize">{{ $prestasi->jenis }}</dd></div>
                <div><dt class="text-slate-400">Tanggal</dt><dd class="font-semibold">{{ $prestasi->tanggal->format('d M Y') }}</dd></div>
            </dl>

            <form method="POST" action="{{ route('panel.validasi.putusan', $prestasi) }}" class="mt-6 space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan (opsional)</label>
                    <textarea name="catatan" rows="2" class="w-full rounded-xl border-slate-300 text-sm">{{ $prestasi->catatan }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button name="status_validasi" value="valid" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">✓ Lolos Validasi</button>
                    <button name="status_validasi" value="ditolak" class="px-4 py-2 rounded-xl bg-rose-500 text-white text-sm font-semibold hover:bg-rose-600">✕ Tolak</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Berkas Sertifikat</h3>
            @if($prestasi->sertifikat_path)
                <a href="{{ route('panel.prestasi.dokumen', $prestasi) }}" target="_blank" class="inline-block px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-sm font-medium mb-3">Buka / Unduh</a>
                <iframe src="{{ route('panel.prestasi.dokumen', $prestasi) }}" class="w-full h-[460px] rounded-lg border"></iframe>
            @else
                <p class="text-sm text-slate-400">Tidak ada dokumen diunggah.</p>
            @endif
        </div>
    </div>
</x-app-layout>
