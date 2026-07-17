<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Prestasi: {{ $siswa->nama }}</h2></x-slot>

    <a href="{{ route('panel.siswa.index') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Kembali ke daftar siswa</a>

    <div class="grid sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border"><div class="text-sm text-slate-500">NIS</div><div class="text-lg font-semibold">{{ $siswa->nis ?? '-' }}</div></div>
        <div class="bg-white rounded-xl shadow-sm p-5 border"><div class="text-sm text-slate-500">Kelas</div><div class="text-lg font-semibold">{{ $siswa->kelas->nama ?? '-' }}</div></div>
        <div class="bg-white rounded-xl shadow-sm p-5 border"><div class="text-sm text-slate-500">Total Prestasi</div><div class="text-lg font-semibold text-blue-600">{{ $siswa->prestasis->count() }}</div></div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Kegiatan</th>
                        <th class="px-5 py-3 text-left">Tingkat</th>
                        <th class="px-5 py-3 text-left">Peringkat</th>
                        <th class="px-5 py-3 text-left">Penyelenggara / Jenis</th>
                        <th class="px-5 py-3 text-left">Nilai Rubrik</th>
                        <th class="px-5 py-3 text-left">Periode</th>
                        <th class="px-5 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                        @forelse($siswa->prestasis as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-medium">
                                    {{ $p->nama_kegiatan }}
                                    <a href="{{ route('panel.prestasi.show', $p) }}" class="block text-[11px] text-blue-600 hover:underline">Lihat detail & dokumen</a>
                                </td>
                                <td class="px-5 py-3 capitalize">{{ $p->tingkat }}</td>
                                <td class="px-5 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                                <td class="px-5 py-3 text-[11px] capitalize">{{ $p->penyelenggara }} / {{ $p->jenis }}</td>
                                <td class="px-5 py-3 font-mono">{{ $p->nilai_rubrik ?? '-' }}</td>
                                <td class="px-5 py-3 text-slate-500">{{ $p->periode->nama ?? '-' }}</td>
                                <td class="px-5 py-3">
                                    @if($p->status_validasi == 'valid')<span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Valid</span>
                                    @elseif($p->status_validasi == 'ditolak')<span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>
                                        <div class="mt-2 flex gap-2">
                                            <form method="POST" action="{{ route('panel.prestasi.validasi', $p) }}">
                                                @csrf
                                                <input type="hidden" name="status_validasi" value="valid">
                                                <button class="px-2 py-1 rounded-lg bg-blue-600 text-white text-[11px] hover:bg-blue-700">Valid</button>
                                            </form>
                                            <form method="POST" action="{{ route('panel.prestasi.validasi', $p) }}">
                                                @csrf
                                                <input type="hidden" name="status_validasi" value="ditolak">
                                                <button class="px-2 py-1 rounded-lg bg-rose-500 text-white text-[11px] hover:bg-rose-600">Tolak</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-6 text-center text-slate-400">Belum ada prestasi.</td></tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
