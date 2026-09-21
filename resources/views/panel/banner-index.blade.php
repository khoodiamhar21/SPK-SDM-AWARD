<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Banner</h1>
            <p class="text-sm text-slate-500">Kelola banner halaman utama.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-200">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 text-red-800 text-sm border border-red-200">{{ $errors->first() }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <h3 class="font-semibold text-slate-700 mb-4">Tambah Banner</h3>
        <form method="POST" action="{{ route('panel.banner.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto (jpg/png/webp, maks 3MB)</label>
                <input type="file" name="foto" required accept="image/*" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul (opsional)</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div class="md:col-span-4">
                <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan Banner</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Foto</th>
                        <th class="px-5 py-3 text-left">Judul</th>
                        <th class="px-5 py-3 text-center">Urutan</th>
                        <th class="px-5 py-3 text-center">Aktif</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($banners as $b)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3"><img src="{{ asset('storage/'.$b->foto_path) }}" class="h-12 w-20 object-cover rounded-lg border" alt=""></td>
                            <td class="px-5 py-3 font-medium">{{ $b->judul ?? '-' }}</td>
                            <td class="px-5 py-3 text-center">{{ $b->urutan }}</td>
                            <td class="px-5 py-3 text-center">{{ $b->aktif ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="{{ route('panel.banner.destroy', $b) }}" onsubmit="return confirm('Hapus banner ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-xl bg-red-100 text-red-700 text-xs font-medium hover:bg-red-200">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada banner.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
