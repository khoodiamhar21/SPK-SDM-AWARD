<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Input Nilai: {{ $prestasi->nama_kegiatan }}</h1>
        <a href="{{ route('panel.penilaian.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-blue-50 text-blue-800 text-sm border border-blue-200">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Data & Rekomendasi Rubrik</h3>
            <dl class="text-sm space-y-3">
                <div><dt class="text-slate-400">Siswa</dt><dd class="font-semibold">{{ $prestasi->siswa->nama ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Penyelenggara</dt><dd class="font-semibold capitalize">{{ $prestasi->penyelenggara }}</dd></div>
                <div><dt class="text-slate-400">Jenis</dt><dd class="font-semibold capitalize">{{ $prestasi->jenis }}</dd></div>
                <div><dt class="text-slate-400">Tingkat</dt><dd class="font-semibold capitalize">{{ $prestasi->tingkat }}</dd></div>
                <div><dt class="text-slate-400">Peringkat</dt><dd class="font-semibold">{{ str_replace('juara','Juara ',$prestasi->peringkat) }}</dd></div>
            </dl>

            <div class="mt-6 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 text-white p-4">
                <div class="text-xs text-blue-50">Nilai Rekomendasi Rubrik (otomatis)</div>
                <div class="text-3xl font-bold">{{ $skorRekomendasi ?? 'Tidak ada' }}</div>
                @if($skorRekomendasi)
                    <div class="text-[11px] text-blue-50/90 mt-1">Sesuai kombinasi kriteria di tabel rubrik.</div>
                @else
                    <div class="text-[11px] text-blue-50/90 mt-1">Kombinasi kriteria belum ada di rubrik.</div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Ceklis / Input Nilai</h3>
            <form method="POST" action="{{ route('panel.penilaian.nilai', $prestasi) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nilai Rubrik (40 - 100)</label>
                    <input type="number" step="0.01" name="nilai_rubrik"
                           value="{{ old('nilai_rubrik', $prestasi->nilai_rubrik ?? $skorRekomendasi) }}"
                           class="w-full rounded-xl border-slate-300 text-sm font-semibold">
                    <p class="text-[11px] text-slate-400 mt-1">Default otomatis dari rekomendasi rubrik. Dapat disesuaikan jika perlu.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan (opsional)</label>
                    <textarea name="catatan" rows="3" class="w-full rounded-xl border-slate-300 text-sm">{{ $prestasi->catatan }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan Nilai</button>
                    @if($skorRekomendasi)
                        <button type="button" onclick="document.querySelector('[name=nilai_rubrik]').value='{{ $skorRekomendasi }}'"
                                class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Pakai Rekomendasi</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
