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
</x-app-layout>
