<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ isset($tingkat) ? 'Edit Tingkat' : 'Tambah Tingkat' }}</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-lg">
        <form method="POST" action="{{ isset($tingkat) ? route('panel.tingkat.update', $tingkat) : route('panel.tingkat.store') }}" class="space-y-4">
            @csrf
            @if(isset($tingkat)) @method('PUT') @endif

            <div>
                <x-input-label for="kode" value="Kode (nilai tersimpan)" />
                <x-text-input id="kode" name="kode" class="mt-1 block w-full" required value="{{ old('kode', $tingkat->kode ?? '') }}" />
                <x-input-error :messages="$errors->get('kode')" class="mt-2" />
                <p class="text-xs text-slate-400 mt-1">Digunakan sebagai nilai di database. Gunakan huruf kecil tanpa spasi. Tidak bisa diubah jika sudah dipakai prestasi.</p>
            </div>

            <div>
                <x-input-label for="nama" value="Nama (tampilan)" />
                <x-text-input id="nama" name="nama" class="mt-1 block w-full" required value="{{ old('nama', $tingkat->nama ?? '') }}" />
                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="kriteria_id" value="Kriteria SAW" />
                <select id="kriteria_id" name="kriteria_id" class="mt-1 block w-full rounded-md border-slate-300" required>
                    <option value="">-- Pilih --</option>
                    @foreach($kriterias as $k)
                        <option value="{{ $k->id }}" {{ old('kriteria_id', $tingkat->kriteria_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->kode }} — {{ $k->nama }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('kriteria_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="urutan" value="Urutan" />
                <x-text-input id="urutan" type="number" name="urutan" class="mt-1 block w-full" required value="{{ old('urutan', $tingkat->urutan ?? '') }}" />
                <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('panel.tingkat.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm">Batal</a>
                <x-primary-button>{{ isset($tingkat) ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
