<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800">Tingkat Kejuaraan</h2>
            <a href="{{ route('panel.tingkat.create') }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">+ Tambah</a>
        </div>
    </x-slot>

    @if(session('status'))
        <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">{{ $errors->first() }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-5 py-3 text-left">Urutan</th>
                    <th class="px-5 py-3 text-left">Kode</th>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Kriteria SAW</th>
                    <th class="px-5 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($tingkats as $t)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">{{ $t->urutan }}</td>
                        <td class="px-5 py-3 font-mono text-xs">{{ $t->kode }}</td>
                        <td class="px-5 py-3 font-semibold">{{ $t->nama }}</td>
                        <td class="px-5 py-3">{{ $t->kriteria->kode }} — {{ $t->kriteria->nama }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('panel.tingkat.edit', $t) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-2">Edit</a>
                            <form method="POST" action="{{ route('panel.tingkat.destroy', $t) }}" class="inline" onsubmit="return confirm('Hapus tingkat {{ $t->nama }}? Semua rubrik dengan tingkat ini akan ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button class="text-rose-600 hover:text-rose-800 text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada data tingkat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-800">
        <strong>Catatan:</strong> Tingkat kejuaraan menentukan kriteria SAW mana yang diisi. Misal: tingkat "Nasional" masuk ke kriteria C1 (bobot tertinggi).
        Kode tingkat digunakan sebagai nilai tersimpan di prestasi, tidak bisa diubah jika sudah dipakai.
    </div>
</x-app-layout>
