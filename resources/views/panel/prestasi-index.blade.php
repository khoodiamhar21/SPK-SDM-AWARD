<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Validasi Prestasi</h2>
    </x-slot>

    <form method="GET" class="mb-4 flex items-center gap-3">
        <label class="text-sm text-slate-500">Periode:</label>
        <select name="periode_id" onchange="this.form.submit()" class="rounded-md border-slate-300 text-sm">
            <option value="">Semua</option>
            @foreach($periodes as $p)
                <option value="{{ $p->id }}" {{ $periodeId == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
            @endforeach
        </select>
    </form>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Siswa</th>
                        <th class="px-4 py-3 text-left">Kegiatan</th>
                        <th class="px-4 py-3 text-left">Tingkat</th>
                        <th class="px-4 py-3 text-left">Peringkat</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($prestasis as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium">{{ $p->siswa->nama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->nama_kegiatan }}</td>
                            <td class="px-4 py-3 capitalize">{{ $p->tingkat }}</td>
                            <td class="px-4 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                            <td class="px-4 py-3">
                                @if($p->status_validasi == 'valid')
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-text-blue-600 text-xs">Valid</span>
                                @elseif($p->status_validasi == 'ditolak')
                                    <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($p->status_validasi == 'menunggu')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('panel.prestasi.validasi', $p) }}">
                                            @csrf
                                            <input type="hidden" name="status_validasi" value="valid">
                                            <button class="px-3 py-1 rounded-lg bg-text-blue-600 text-white text-xs hover:bg-text-blue-600">Valid</button>
                                        </form>
                                        <form method="POST" action="{{ route('panel.prestasi.validasi', $p) }}">
                                            @csrf
                                            <input type="hidden" name="status_validasi" value="ditolak">
                                            <button class="px-3 py-1 rounded-lg bg-rose-500 text-white text-xs hover:bg-rose-600">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-slate-400">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3">
            {{ $prestasis->links() }}
        </div>
    </div>
</x-app-layout>
