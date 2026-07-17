<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Rubrik Penilaian</h1>
            <p class="text-sm text-slate-500">Panduan skor prestasi (40-100) berdasarkan kombinasi kriteria.</p>
        </div>
        <a href="{{ route('panel.rubrik.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Rubrik
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
                        <th class="px-4 py-3 text-left font-medium">Kode</th>
                        <th class="px-4 py-3 text-left font-medium">Penyelenggara</th>
                        <th class="px-4 py-3 text-left font-medium">Peringkat</th>
                        <th class="px-4 py-3 text-left font-medium">Jenis</th>
                        <th class="px-4 py-3 text-left font-medium">Tingkat</th>
                        <th class="px-4 py-3 text-left font-medium">Skor</th>
                        <th class="px-4 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($rubriks as $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $r->kode }}</td>
                            <td class="px-4 py-3 capitalize">{{ $r->penyelenggara }}</td>
                            <td class="px-4 py-3">{{ str_replace('juara','Juara ',$r->peringkat) }}</td>
                            <td class="px-4 py-3 capitalize">{{ $r->jenis }}</td>
                            <td class="px-4 py-3 capitalize">{{ $r->tingkat }}</td>
                            <td class="px-4 py-3 font-semibold text-blue-600">{{ $r->skor }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('panel.rubrik.edit', $r) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('panel.rubrik.destroy', $r) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rubrik ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-rose-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-slate-500">Belum ada data rubrik.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
