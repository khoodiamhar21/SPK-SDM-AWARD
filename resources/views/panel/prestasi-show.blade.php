<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800">Detail Prestasi</h2>
            <a href="{{ route('panel.prestasi.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    @if(session('status'))
        <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Data prestasi -->
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Data Prestasi</h3>
            <dl class="text-sm space-y-3">
                <div><dt class="text-slate-400">Siswa</dt><dd class="font-semibold">{{ $prestasi->siswa->nama ?? '-' }}</dd></div>
                <div><dt class="text-slate-400">Kegiatan</dt><dd class="font-semibold">{{ $prestasi->nama_kegiatan }}</dd></div>
                <div><dt class="text-slate-400">Tingkat</dt><dd class="font-semibold capitalize">{{ $prestasi->tingkat }}</dd></div>
                <div><dt class="text-slate-400">Peringkat</dt><dd class="font-semibold">{{ str_replace('juara','Juara ',$prestasi->peringkat) }}</dd></div>
                <div><dt class="text-slate-400">Penyelenggara</dt><dd class="font-semibold capitalize">{{ $prestasi->penyelenggara }}</dd></div>
                <div><dt class="text-slate-400">Jenis Prestasi</dt><dd class="font-semibold capitalize">{{ $prestasi->jenis }}</dd></div>
                <div><dt class="text-slate-400">Tanggal</dt><dd class="font-semibold">{{ $prestasi->tanggal->format('d M Y') }}</dd></div>
                <div><dt class="text-slate-400">Periode</dt><dd class="font-semibold">{{ $prestasi->periode->nama ?? '-' }}</dd></div>
                @if($prestasi->catatan)
                    <div><dt class="text-slate-400">Catatan</dt><dd class="font-semibold">{{ $prestasi->catatan }}</dd></div>
                @endif
                <div>
                    <dt class="text-slate-400">Status</dt>
                    <dd class="font-semibold">
                        @if($prestasi->status_validasi == 'valid')
                            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">Valid</span>
                        @elseif($prestasi->status_validasi == 'ditolak')
                            <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <!-- Nilai rubrik -->
            <div class="mt-6 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 text-white p-4">
                <div class="text-xs text-blue-50">Nilai Rubrik (otomatis)</div>
                <div class="text-2xl font-bold">{{ $skorRubrik ?? 'Belum ditentukan' }}</div>
                <div class="text-[11px] text-blue-50/90 mt-1">Diisi otomatis saat status Valid, berdasarkan kombinasi kriteria</div>
            </div>

            <!-- Validasi -->
            @if($prestasi->status_validasi == 'menunggu')
                <div class="mt-6 flex gap-3">
                    <form method="POST" action="{{ route('panel.prestasi.validasi', $prestasi) }}">
                        @csrf
                        <input type="hidden" name="status_validasi" value="valid">
                        <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Valid / Setujui</button>
                    </form>
                    <form method="POST" action="{{ route('panel.prestasi.validasi', $prestasi) }}">
                        @csrf
                        <input type="hidden" name="status_validasi" value="ditolak">
                        <button class="px-4 py-2 rounded-xl bg-rose-500 text-white text-sm font-semibold hover:bg-rose-600">Tolak</button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Dokumen -->
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold text-slate-700 mb-4">Dokumen / Sertifikat</h3>
            @if($prestasi->sertifikat_path)
                <a href="{{ route('panel.prestasi.dokumen', $prestasi) }}" target="_blank"
                   class="inline-block px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-sm font-medium">Buka / Unduh Dokumen</a>
                <iframe src="{{ route('panel.prestasi.dokumen', $prestasi) }}" class="w-full h-[500px] mt-4 rounded-lg border"></iframe>
            @else
                <p class="text-sm text-slate-400">Tidak ada dokumen diunggah.</p>
            @endif
        </div>
    </div>
</x-app-layout>
