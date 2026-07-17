<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">{{ isset($periode) ? 'Edit Periode' : 'Tambah Periode' }}</h1>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-xl">
        <form method="POST" action="{{ isset($periode) ? route('panel.periode.update', $periode) : route('panel.periode.store') }}">
            @csrf
            @if(isset($periode)) @method('PUT') @endif
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Periode</label>
                    <input name="nama" value="{{ old('nama', $periode->nama ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tahun</label>
                    <input name="tahun" type="number" value="{{ old('tahun', $periode->tahun ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tgl Buka</label>
                        <input name="tgl_buka" type="date" value="{{ old('tgl_buka', $periode->tgl_buka ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tgl Tutup</label>
                        <input name="tgl_tutup" type="date" value="{{ old('tgl_tutup', $periode->tgl_tutup ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1">
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $periode->aktif ?? false) ? 'checked' : '' }}> Jadikan periode aktif
                </label>
            </div>
            @if($errors->any())
                <div class="mt-4 text-sm text-rose-600">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            @endif
            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Simpan</button>
                <a href="{{ route('panel.periode.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
