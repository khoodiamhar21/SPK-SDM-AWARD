<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Input Prestasi</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form method="POST" action="{{ route('prestasi.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="nama_kegiatan" value="Nama Kegiatan" />
                <x-text-input id="nama_kegiatan" name="nama_kegiatan" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('nama_kegiatan')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tingkat" value="Tingkat Kejuaraan" />
                    <select id="tingkat" name="tingkat" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        <option value="kabupaten">Kabupaten/Kota</option>
                        <option value="provinsi">Provinsi</option>
                        <option value="nasional">Nasional</option>
                        <option value="internasional">Internasional</option>
                    </select>
                    <x-input-error :messages="$errors->get('tingkat')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="peringkat" value="Peringkat" />
                    <select id="peringkat" name="peringkat" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        <option value="juara1">Juara 1</option>
                        <option value="juara2">Juara 2</option>
                        <option value="juara3">Juara 3</option>
                    </select>
                    <x-input-error :messages="$errors->get('peringkat')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="penyelenggara" value="Jenis Penyelenggara" />
                    <select id="penyelenggara" name="penyelenggara" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        <option value="pemerintah">Instansi Pemerintahan</option>
                        <option value="swasta">Instansi Swasta</option>
                    </select>
                    <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="jenis" value="Jenis Prestasi" />
                    <select id="jenis" name="jenis" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        <option value="perorangan">Perorangan</option>
                        <option value="beregu">Beregu</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tanggal" value="Tanggal Sertifikat" />
                    <x-text-input id="tanggal" type="date" name="tanggal" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id" class="mt-1 block w-full rounded-md border-slate-300" required>
                        @foreach($periodes as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="sertifikat" value="Upload Sertifikat (pdf/jpg/png, max 2MB)" />
                <input id="sertifikat" type="file" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png"
                    class="mt-1 block w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-text-blue-600 hover:file:bg-blue-100" />
                <x-input-error :messages="$errors->get('sertifikat')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="catatan" value="Catatan (opsional)" />
                <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full rounded-md border-slate-300"></textarea>
            </div>

            <div class="flex justify-end">
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
