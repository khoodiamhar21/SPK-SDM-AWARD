<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Dashboard Siswa</h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Nama</div>
            <div class="text-lg font-semibold text-text-blue-600">{{ $siswa->nama ?? '-' }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Kelas</div>
            <div class="text-2xl font-bold">{{ $siswa->kelas ?? '-' }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Periode</div>
            <div class="text-sm font-semibold">{{ $periodeAktif->nama ?? '-' }}</div>
        </div>
        <div class="bg-gradient-to-br from-blue-600 to-sky-500 rounded-xl shadow-sm p-5 border text-white">
            <div class="text-sm text-blue-50">Nilai Sementara (SAW)</div>
            @if($nilaiSementara)
                <div class="text-2xl font-bold">{{ number_format($nilaiSementara['total_vi'], 4) }}</div>
                <div class="text-[11px] text-blue-50/90 mt-1">Peringkat sementara #{{ $nilaiSementara['peringkat'] }} · {{ $nilaiSementara['jumlah_prestasi'] }} prestasi valid</div>
            @else
                <div class="text-lg font-semibold opacity-90">Belum ada prestasi valid</div>
            @endif
        </div>
    </div>

    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-slate-800">Prestasi Saya</h3>
        <a href="{{ route('prestasi.create') }}" class="inline-flex items-center px-4 py-2 bg-text-blue-600 text-white text-sm rounded-lg hover:bg-text-blue-600">+ Input Prestasi</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Kegiatan</th>
                        <th class="px-5 py-3 text-left">Tingkat</th>
                        <th class="px-5 py-3 text-left">Peringkat</th>
                        <th class="px-5 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($prestasis as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium">{{ $p->nama_kegiatan }}</td>
                            <td class="px-5 py-3 capitalize">{{ $p->tingkat }}</td>
                            <td class="px-5 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                            <td class="px-5 py-3">
                                @if($p->status_validasi == 'valid')
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-text-blue-600 text-xs">Valid</span>
                                @elseif($p->status_validasi == 'ditolak')
                                    <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-slate-400">Belum ada data prestasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($showNaikKelas && $siswa)
        <div x-data="{ open: true }" x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-xl">
                <h3 class="font-semibold text-lg text-slate-800">Naik ke kelas berikutnya?</h3>
                <p class="text-sm text-slate-500 mt-2">Kelas saat ini: <b>{{ $siswa->kelas?->nama }}</b>. Periode baru: <b>{{ $periodeAktif->nama }}</b>.</p>
                <div class="mt-5 flex gap-3">
                    <form method="POST" action="{{ route('siswa.naik-kelas') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Naik Kelas</button>
                    </form>
                    <button @click="open=false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Nanti / Lewati</button>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
