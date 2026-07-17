<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-xl font-semibold text-slate-800">Validasi Sertifikat</h1><p class="text-sm text-slate-500">Pilih kelas → siswa → prestasi.</p></div>
    </div>

    @if(!$periode)
        <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($kelas as $k)
                <a href="{{ route('panel.validasi.siswa', $k) }}" class="bg-white rounded-2xl border p-6 text-center hover:shadow-md hover:border-blue-300 transition-all">
                    <div class="text-2xl font-bold text-blue-700">Kelas {{ $k->nama }}</div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            <h2 class="font-semibold text-slate-800 mb-3">Rekap Validasi Berkas</h2>
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="grid grid-cols-[1fr_1.4fr_1.6fr_0.8fr] gap-2 px-4 py-3 bg-slate-50 text-slate-500 text-sm font-medium border-b">
                    <div>Kelas</div>
                    <div>Nama Siswa</div>
                    <div>Kegiatan</div>
                    <div>Status</div>
                </div>
                <div class="h-[320px] overflow-y-auto divide-y">
                    @forelse($rekap as $r)
                        <div class="grid grid-cols-[1fr_1.4fr_1.6fr_0.8fr] gap-2 px-4 py-3 text-sm hover:bg-slate-50 items-center">
                            <div class="text-slate-500">Kelas {{ $r->siswa?->kelas?->nama ?? '-' }}</div>
                            <div class="font-medium">{{ $r->siswa?->nama ?? '-' }}</div>
                            <div>{{ $r->nama_kegiatan }}</div>
                            <div>
                                @if($r->status_validasi=='valid')<span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Lolos</span>
                                @elseif($r->status_validasi=='ditolak')<span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                                @else<span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>@endif
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center text-slate-500 text-sm">Belum ada data prestasi pada periode ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
