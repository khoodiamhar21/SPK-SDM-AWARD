<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Kelola Berita</h2></x-slot>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold mb-4">Tambah Berita</h3>
            <form method="POST" action="{{ route('panel.berita.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="judul" value="Judul" />
                    <x-text-input id="judul" name="judul" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="kategori" value="Kategori" />
                        <x-text-input id="kategori" name="kategori" class="mt-1 block w-full" value="Prestasi" required />
                    </div>
                    <div>
                        <x-input-label for="tanggal" value="Tanggal" />
                        <x-text-input id="tanggal" type="date" name="tanggal" class="mt-1 block w-full" required />
                    </div>
                </div>
                <div>
                    <x-input-label for="isi" value="Isi (opsional)" />
                    <textarea name="isi" rows="3" class="mt-1 block w-full rounded-md border-slate-300"></textarea>
                </div>
                <div>
                    <x-input-label for="foto" value="Foto (opsional)" />
                    <input type="file" name="foto" accept="image/*" class="mt-1 block w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700">
                </div>
                <x-primary-button>Simpan</x-primary-button>
            </form>
        </div>
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6 space-y-3">
            @forelse($beritas as $b)
                <div class="flex items-start gap-3 border-b pb-3">
                    @if($b->foto_path)<img src="{{ asset('storage/'.$b->foto_path) }}" class="h-14 w-14 rounded-lg object-cover shrink-0" alt="">@endif
                    <div class="flex-1">
                        <div class="text-sm font-semibold">{{ $b->judul }}</div>
                        <div class="text-xs text-slate-400">{{ $b->kategori }} · {{ $b->tanggal->format('d M Y') }}</div>
                    </div>
                    <form method="POST" action="{{ route('panel.berita.destroy', $b) }}" onsubmit="return confirm('Hapus berita?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-600 text-sm">Hapus</button>
                    </form>
                </div>
            @empty
                <div class="text-slate-400 text-sm">Belum ada berita.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
