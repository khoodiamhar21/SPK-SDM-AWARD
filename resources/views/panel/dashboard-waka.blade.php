<x-app-layout>
    @if($periodeAktif)
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-sm p-5 border">
                <div class="text-sm text-slate-500">Periode Aktif</div>
                <div class="text-lg font-semibold text-blue-600">{{ $periodeAktif->nama }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('panel.rekap.index') }}" class="group bg-white rounded-xl shadow-sm border p-6 hover:border-blue-400 hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <x-icon name="star" class="h-6 w-6" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800 text-lg">Rekap Prestasi Siswa</div>
                        <div class="text-sm text-slate-500">Lihat rekap nilai seluruh siswa per periode.</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('panel.validasi.kelas') }}" class="group bg-white rounded-xl shadow-sm border p-6 hover:border-blue-400 hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <x-icon name="doc" class="h-6 w-6" />
                    </div>
                    <div>
                        <div class="font-semibold text-slate-800 text-lg">Validasi Sertifikat</div>
                        <div class="text-sm text-slate-500">Validasi berkas prestasi siswa per kelas.</div>
                    </div>
                </div>
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border p-6 text-slate-500">Belum ada periode aktif. Hubungi administrator.</div>
    @endif
</x-app-layout>
