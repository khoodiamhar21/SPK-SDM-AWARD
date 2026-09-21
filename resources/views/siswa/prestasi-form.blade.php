<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ $prestasi ? 'Edit Prestasi' : 'Input Prestasi' }}</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form method="POST" action="{{ $prestasi ? route('prestasi.update', $prestasi) : route('prestasi.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($prestasi) @method('PUT') @endif

            <div>
                <x-input-label for="nama_kegiatan" value="Nama Kegiatan" />
                <x-text-input id="nama_kegiatan" name="nama_kegiatan" class="mt-1 block w-full" required value="{{ old('nama_kegiatan', $prestasi->nama_kegiatan ?? '') }}" />
                <x-input-error :messages="$errors->get('nama_kegiatan')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="jenis_prestasi" value="Jenis Prestasi" />
                    <select id="jenis_prestasi" name="jenis_prestasi" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['akademik' => 'Akademik', 'non_akademik' => 'Non-Akademik'] as $val => $label)
                            <option value="{{ $val }}" {{ old('jenis_prestasi', $prestasi->jenis_prestasi ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('jenis_prestasi')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="kategori_lomba_id" value="Kategori Lomba" />
                    <select id="kategori_lomba_id" name="kategori_lomba_id" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih Jenis Prestasi Terlebih Dahulu --</option>
                    </select>
                    <x-input-error :messages="$errors->get('kategori_lomba_id')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tingkat" value="Tingkat Kejuaraan" />
                    <select id="tingkat" name="tingkat" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        @foreach($tingkats as $t)
                            <option value="{{ $t->kode }}" {{ old('tingkat', $prestasi->tingkat ?? '') == $t->kode ? 'selected' : '' }}>{{ $t->nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tingkat')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="peringkat" value="Peringkat" />
                    <select id="peringkat" name="peringkat" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['juara1' => 'Juara 1', 'juara2' => 'Juara 2', 'juara3' => 'Juara 3'] as $val => $label)
                            <option value="{{ $val }}" {{ old('peringkat', $prestasi->peringkat ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('peringkat')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="jenis" value="Jenis (Perorangan/Beregu)" />
                    <select id="jenis" name="jenis" class="mt-1 block w-full rounded-md border-slate-300" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['perorangan' => 'Perorangan', 'beregu' => 'Beregu'] as $val => $label)
                            <option value="{{ $val }}" {{ old('jenis', $prestasi->jenis ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="tanggal" value="Tanggal Sertifikat" />
                    <x-text-input id="tanggal" type="date" name="tanggal" class="mt-1 block w-full" required value="{{ old('tanggal', $prestasi->tanggal ?? '') }}" />
                    <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id" class="mt-1 block w-full rounded-md border-slate-300" required>
                        @foreach($periodes as $p)
                            <option value="{{ $p->id }}" {{ old('periode_id', $prestasi->periode_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="sertifikat" value="{{ $prestasi ? 'Ganti Sertifikat (pdf/jpg/png, max 2MB)' : 'Upload Sertifikat (pdf/jpg/png, max 2MB)' }}" />
                <input id="sertifikat" type="file" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png"
                    class="mt-1 block w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-text-blue-600 hover:file:bg-blue-100" />
                @if($prestasi && $prestasi->sertifikat_path)
                    <p class="text-xs text-slate-400 mt-1">Sertifikat saat ini: {{ basename($prestasi->sertifikat_path) }}</p>
                @endif
                <x-input-error :messages="$errors->get('sertifikat')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="catatan" value="Catatan (opsional)" />
                <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full rounded-md border-slate-300">{{ old('catatan', $prestasi->catatan ?? '') }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('prestasi.status') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm">Batal</a>
                <x-primary-button>{{ $prestasi ? 'Simpan Perubahan' : 'Simpan' }}</x-primary-button>
            </div>
        </form>
    </div>

    @php
        $kategorisJson = $kategoris->map(fn($k) => ['id' => $k->id, 'nama' => $k->nama, 'jenis' => $k->jenis_prestasi])->values();
    @endphp
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoris = @json($kategorisJson);
        const jenisSelect = document.getElementById('jenis_prestasi');
        const kategoriSelect = document.getElementById('kategori_lomba_id');
        const oldJenis = '{{ old('jenis_prestasi', $prestasi->jenis_prestasi ?? '') }}';
        const oldKategori = '{{ old('kategori_lomba_id', $prestasi->kategori_lomba_id ?? '') }}';

        function filterKategori() {
            const jenis = jenisSelect.value;
            const prev = kategoriSelect.value;
            kategoriSelect.innerHTML = '<option value="">-- Pilih --</option>';
            kategoris.filter(k => k.jenis === jenis).forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.id;
                opt.textContent = k.nama;
                if (String(k.id) === String(prev)) opt.selected = true;
                kategoriSelect.appendChild(opt);
            });
        }

        if (oldJenis) {
            jenisSelect.value = oldJenis;
            filterKategori();
            if (oldKategori) kategoriSelect.value = oldKategori;
        }

        jenisSelect.addEventListener('change', function() {
            kategoriSelect.innerHTML = '<option value="">-- Pilih --</option>';
            if (this.value) filterKategori();
        });
    });
    </script>
</x-app-layout>
