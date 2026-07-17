<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Kelola Kelas</h1>
            <p class="text-sm text-slate-500">Master kelas 1-6 (urutan untuk kenaikan otomatis).</p>
        </div>
        <a href="{{ route('panel.kelas.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Kelas
        </a>
    </div>
    @if(session('success'))<div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">{{ session('success') }}</div>@endif
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr><th class="px-4 py-3 text-left">Nama</th><th class="px-4 py-3 text-left">Urutan</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($kelas as $k)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium">{{ $k->nama }}</td>
                        <td class="px-4 py-3">{{ $k->urutan }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('panel.kelas.edit', $k) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('panel.kelas.destroy', $k) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-rose-600 hover:underline">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada kelas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
