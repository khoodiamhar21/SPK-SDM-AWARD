<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Kelola Pengumuman</h2></x-slot>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h3 class="font-semibold mb-4">Tambah Pengumuman</h3>
            <form method="POST" action="{{ route('panel.pengumuman.store') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="judul" value="Judul" />
                    <x-text-input id="judul" name="judul" class="mt-1 block w-full" required />
                </div>
                <div>
                    <x-input-label for="tanggal" value="Tanggal" />
                    <x-text-input id="tanggal" type="date" name="tanggal" class="mt-1 block w-full" required />
                </div>
                <div>
                    <x-input-label for="isi" value="Isi" />
                    <textarea name="isi" rows="4" class="mt-1 block w-full rounded-md border-slate-300"></textarea>
                </div>
                <x-primary-button>Simpan</x-primary-button>
            </form>
        </div>
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6 space-y-3">
            @forelse($pengumumans as $p)
                <div class="flex items-start gap-3 border-b pb-3">
                    <div class="flex-1">
                        <div class="text-sm font-semibold">{{ $p->judul }}</div>
                        <div class="text-xs text-slate-400">{{ $p->tanggal->format('d M Y') }}</div>
                        @if($p->isi)<p class="text-sm text-slate-600 mt-1">{{ $p->isi }}</p>@endif
                    </div>
                    <form method="POST" action="{{ route('panel.pengumuman.destroy', $p) }}" onsubmit="return confirm('Hapus pengumuman?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-600 text-sm">Hapus</button>
                    </form>
                </div>
            @empty
                <div class="text-slate-400 text-sm">Belum ada pengumuman.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
