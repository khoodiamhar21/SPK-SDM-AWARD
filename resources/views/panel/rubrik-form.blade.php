<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">{{ isset($rubrik) ? 'Edit Rubrik' : 'Tambah Rubrik' }}</h1>
        <p class="text-sm text-slate-500">Kombinasi unik penyelenggara + peringkat + jenis + tingkat menentukan satu skor.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form method="POST" action="{{ isset($rubrik) ? route('panel.rubrik.update', $rubrik) : route('panel.rubrik.store') }}">
            @csrf
            @if(isset($rubrik)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Penyelenggara</label>
                    <select name="penyelenggara" class="w-full rounded-xl border-slate-300 text-sm">
                        <option value="pemerintah" {{ old('penyelenggara', $rubrik->penyelenggara ?? '') == 'pemerintah' ? 'selected' : '' }}>Instansi Pemerintahan</option>
                        <option value="swasta" {{ old('penyelenggara', $rubrik->penyelenggara ?? '') == 'swasta' ? 'selected' : '' }}>Instansi Swasta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Peringkat Juara</label>
                    <select name="peringkat" class="w-full rounded-xl border-slate-300 text-sm">
                        <option value="juara1" {{ old('peringkat', $rubrik->peringkat ?? '') == 'juara1' ? 'selected' : '' }}>Juara 1</option>
                        <option value="juara2" {{ old('peringkat', $rubrik->peringkat ?? '') == 'juara2' ? 'selected' : '' }}>Juara 2</option>
                        <option value="juara3" {{ old('peringkat', $rubrik->peringkat ?? '') == 'juara3' ? 'selected' : '' }}>Juara 3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Prestasi</label>
                    <select name="jenis" class="w-full rounded-xl border-slate-300 text-sm">
                        <option value="perorangan" {{ old('jenis', $rubrik->jenis ?? '') == 'perorangan' ? 'selected' : '' }}>Perorangan</option>
                        <option value="beregu" {{ old('jenis', $rubrik->jenis ?? '') == 'beregu' ? 'selected' : '' }}>Beregu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tingkat Kejuaraan</label>
                    <select name="tingkat" class="w-full rounded-xl border-slate-300 text-sm">
                        <option value="nasional" {{ old('tingkat', $rubrik->tingkat ?? '') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="provinsi" {{ old('tingkat', $rubrik->tingkat ?? '') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                        <option value="kabupaten" {{ old('tingkat', $rubrik->tingkat ?? '') == 'kabupaten' ? 'selected' : '' }}>Kabupaten/Kota</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode</label>
                    <input type="text" name="kode" value="{{ old('kode', $rubrik->kode ?? '') }}" placeholder="AA1" class="w-full rounded-xl border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Skor (40-100)</label>
                    <input type="number" step="0.01" name="skor" value="{{ old('skor', $rubrik->skor ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm">
                </div>
            </div>

            @if($errors->any())
                <div class="mt-4 text-sm text-rose-600">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
            @endif

            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Simpan</button>
                <a href="{{ route('panel.rubrik.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
