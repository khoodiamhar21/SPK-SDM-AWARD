<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Kelola Banner</h2></x-slot>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold mb-4">Tambah Banner</h3>
            <form method="POST" action="{{ route('panel.banner.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="foto" value="Foto Banner" />
                    <input type="file" name="foto" accept="image/*" required class="mt-1 block w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700">
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="judul" value="Judul (opsional)" />
                    <x-text-input id="judul" name="judul" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="urutan" value="Urutan" />
                    <x-text-input id="urutan" type="number" name="urutan" class="mt-1 block w-full" value="0" />
                </div>
                <x-primary-button>Simpan</x-primary-button>
            </form>
        </div>
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">
            <div class="grid sm:grid-cols-2 gap-4">
                @forelse($banners as $b)
                    <div class="border rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/'.$b->foto_path) }}" class="h-32 w-full object-cover" alt="">
                        <div class="p-3 flex items-center justify-between">
                            <div class="text-sm">
                                <div class="font-medium truncate">{{ $b->judul ?? 'Tanpa judul' }}</div>
                                <div class="text-xs text-slate-400">Urutan {{ $b->urutan }}</div>
                            </div>
                            <form method="POST" action="{{ route('panel.banner.destroy', $b) }}" onsubmit="return confirm('Hapus banner?')">
                                @csrf @method('DELETE')
                                <button class="text-rose-600 hover:text-rose-700 text-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-slate-400 text-sm">Belum ada banner.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
