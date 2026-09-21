<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Berita</h1>
            <p class="text-sm text-slate-500">Kelola berita halaman utama.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-200">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 text-red-800 text-sm border border-red-200">{{ $errors->first() }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <h3 class="font-semibold text-slate-700 mb-4">Tambah Berita</h3>
        <form method="POST" action="{{ route('panel.berita.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
                <input type="text" name="judul" required value="{{ old('judul') }}" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <input type="text" name="kategori" required value="{{ old('kategori', 'Prestasi') }}" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto (opsional, maks 3MB)</label>
                <input type="file" name="foto" accept="image/*" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Isi</label>
                <textarea name="isi" rows="4" class="w-full rounded-xl border border-slate-300 text-sm px-3 py-2">{{ old('isi') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan Berita</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Judul</th>
                        <th class="px-5 py-3 text-left">Kategori</th>
                        <th class="px-5 py-3 text-left">Tanggal</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($beritas as $b)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium">{{ $b->judul }}</td>
                            <td class="px-5 py-3">{{ $b->kategori }}</td>
                            <td class="px-5 py-3">{{ $b->tanggal->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="{{ route('panel.berita.destroy', $b) }}" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 rounded-xl bg-red-100 text-red-700 text-xs font-medium hover:bg-red-200">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-slate-400">Belum ada berita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
