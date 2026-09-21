<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Rubrik Penilaian</h1>
            <p class="text-sm text-slate-500">Panduan skor prestasi (40-100) berdasarkan kategori lomba, peringkat, jenis & tingkat.</p>
        </div>
        <a href="{{ route('panel.rubrik.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Rubrik
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
        <div class="px-5 py-4 flex items-center justify-between gap-3 border-b">
            <div>
                <h2 class="font-semibold text-slate-800">Kategori Lomba</h2>
                <p class="text-xs text-slate-500">Kategori bisa dipilih atau ditambah sendiri saat membuat rubrik.</p>
            </div>
            <form method="POST" action="{{ route('panel.rubrik.kategori.store') }}" class="flex gap-2" x-data="{ open: false }">
                @csrf
                <template x-if="open">
                    <input type="text" name="nama" placeholder="Nama kategori baru" class="rounded-xl border-slate-300 text-sm" required>
                </template>
                <button type="button" @click="open = !open" class="shrink-0 px-3 py-2 rounded-xl border border-blue-200 text-blue-700 text-sm font-medium hover:bg-blue-50">+ Kategori</button>
                <button class="shrink-0 px-3 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Simpan</button>
            </form>
        </div>
        <div class="px-5 py-3">
            @php $kategoris = \App\Models\KategoriLomba::orderBy('nama')->get(); @endphp
            @forelse($kategoris as $k)
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-medium mr-2 mb-2">
                    {{ $k->nama }}
                    <form method="POST" action="{{ route('panel.rubrik.kategori.destroy', $k) }}" class="inline" onsubmit="return confirm('Hapus kategori {{ $k->nama }}?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-500 hover:text-rose-700">&times;</button>
                    </form>
                </span>
            @empty
                <span class="text-sm text-slate-400">Belum ada kategori lomba.</span>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Kode</th>
                        <th class="px-4 py-3 text-left font-medium">Kategori Lomba</th>
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
                            <td class="px-4 py-3">{{ $r->kategoriLomba?->nama ?? '-' }}</td>
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