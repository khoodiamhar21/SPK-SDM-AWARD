<x-app-layout>
    <div class="mb-6"><h1 class="text-xl font-semibold text-slate-800">{{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}</h1></div>
    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form method="POST" action="{{ isset($siswa) ? route('panel.siswa.update', $siswa) : route('panel.siswa.store') }}">
            @csrf @if(isset($siswa)) @method('PUT') @endif
            <div class="space-y-4">
                <div><label class="block text-sm font-medium text-slate-700">NISN</label><input name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
                <div><label class="block text-sm font-medium text-slate-700">Nama</label><input name="nama" value="{{ old('nama', $siswa->nama ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
                <div><label class="block text-sm font-medium text-slate-700">Kelas</label>
                    <select name="kelas_id" class="w-full rounded-xl border-slate-300 text-sm mt-1">
                        @foreach($kelas as $k)<option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>@endforeach
                    </select>
                </div>
                <div><label class="block text-sm font-medium text-slate-700">Tempat Lahir</label><input name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
                <div><label class="block text-sm font-medium text-slate-700">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($siswa) && $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
                <div><label class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                    <div class="mt-1 flex items-center gap-4 text-sm">
                        <label class="inline-flex items-center gap-1"><input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}> Laki-laki</label>
                        <label class="inline-flex items-center gap-1"><input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}> Perempuan</label>
                    </div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700">Alamat</label><textarea name="alamat" class="w-full rounded-xl border-slate-300 text-sm mt-1">{{ old('alamat', $siswa->alamat ?? '') }}</textarea></div>
                <div><label class="block text-sm font-medium text-slate-700">No HP Ortu</label><input name="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
            </div>
            @if($errors->any())<div class="mt-4 text-sm text-rose-600">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Simpan</button>
                <a href="{{ route('panel.siswa.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
