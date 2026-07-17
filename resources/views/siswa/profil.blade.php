<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Profil Siswa</h2>
    </x-slot>

    <div class="max-w-3xl">
        @if (session('status'))
            <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nisn" value="NISN" />
                        <x-text-input id="nisn" name="nisn" :value="old('nisn', $siswa->nisn ?? '')" class="mt-1 block w-full" disabled />
                    </div>
                    <div>
                        <x-input-label for="nama" value="Nama" />
                        <x-text-input id="nama" name="nama" :value="old('nama', $siswa->nama ?? '')" class="mt-1 block w-full" disabled />
                    </div>
                    <div>
                        <x-input-label for="kelas" value="Kelas" />
                        <x-text-input id="kelas" name="kelas" :value="old('kelas', optional($siswa->kelas)->nama ?? '')" class="mt-1 block w-full" disabled />
                    </div>
                    <div>
                        <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                        <x-text-input id="tempat_lahir" name="tempat_lahir" :value="old('tempat_lahir', $siswa->tempat_lahir ?? '')" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $siswa->tanggal_lahir ?? '')" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-slate-300">
                            <option value="">-</option>
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="no_hp_ortu" value="No HP Ortu" />
                        <x-text-input id="no_hp_ortu" name="no_hp_ortu" :value="old('no_hp_ortu', $siswa->no_hp_ortu ?? '')" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="foto" value="Foto" />
                        <input id="foto" type="file" name="foto" accept="image/*" class="mt-1 block w-full text-sm">
                        @if($siswa->foto ?? null)
                            <img src="{{ asset('storage/'.$siswa->foto) }}" class="mt-2 h-16 w-16 rounded-full object-cover">
                        @endif
                    </div>
                </div>

                <div>
                    <x-input-label for="alamat" value="Alamat" />
                    <textarea id="alamat" name="alamat" rows="2" class="mt-1 block w-full rounded-md border-slate-300">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
