<x-app-layout>
    <div class="mb-6"><h1 class="text-xl font-semibold text-slate-800">{{ isset($k) ? 'Edit Kelas' : 'Tambah Kelas' }}</h1></div>
    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-sm">
        <form method="POST" action="{{ isset($k) ? route('panel.kelas.update', $k) : route('panel.kelas.store') }}">
            @csrf @if(isset($k)) @method('PUT') @endif
            <div class="space-y-4">
                <div><label class="block text-sm font-medium text-slate-700">Nama (I-VI)</label><input name="nama" value="{{ old('nama', $k->nama ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
                <div><label class="block text-sm font-medium text-slate-700">Urutan (1-6)</label><input name="urutan" type="number" value="{{ old('urutan', $k->urutan ?? '') }}" class="w-full rounded-xl border-slate-300 text-sm mt-1"></div>
            </div>
            @if($errors->any())<div class="mt-4 text-sm text-rose-600">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Simpan</button>
                <a href="{{ route('panel.kelas.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
