<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-xl font-semibold text-slate-800">Penilaian</h1><p class="text-sm text-slate-500">Pilih kelas → siswa → prestasi untuk input nilai rubrik.</p></div>
    </div>
    @if(!$periode)<div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>@else
    @if($kelas->isEmpty())<div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada siswa dengan prestasi lolos validasi di periode ini.</div>@else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($kelas as $k)
            <a href="{{ route('panel.penilaian.siswa', $k) }}" class="bg-white rounded-2xl border p-6 text-center hover:shadow-md hover:border-blue-300 transition-all">
                <div class="text-2xl font-bold text-blue-700">Kelas {{ $k->nama }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ $k->siswas_count }} siswa</div>
            </a>
        @endforeach
    </div>
    @endif
    @endif
</x-app-layout>
