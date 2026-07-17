<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Kelola Periode</h1>
            <p class="text-sm text-slate-500">Atur periode SDM Award (satu periode aktif).</p>
        </div>
        <a href="{{ route('panel.periode.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Periode
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Tahun</th>
                        <th class="px-4 py-3 text-left">Buka</th>
                        <th class="px-4 py-3 text-left">Tutup</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($periodes as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $p->nama }}</td>
                            <td class="px-4 py-3">{{ $p->tahun }}</td>
                            <td class="px-4 py-3">{{ $p->tgl_buka ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $p->tgl_tutup ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($p->aktif)<span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Aktif</span>@else<span class="px-2 py-1 rounded-full bg-slate-100 text-slate-500 text-xs">Nonaktif</span>@endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('panel.periode.edit', $p) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('panel.periode.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus periode?')">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-slate-500">Belum ada periode.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
