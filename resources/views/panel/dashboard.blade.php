<x-app-layout>
    @if($periodeAktif)
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Periode Aktif</div>
            <div class="text-lg font-semibold text-blue-600">{{ $periodeAktif->nama }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Total Prestasi</div>
            <div class="text-2xl font-bold">{{ $totalPrestasi }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Menunggu Validasi</div>
            <div class="text-2xl font-bold text-amber-600">{{ $menunggu }}</div>
        </div>
    </div>

    @if($periodeAktif)
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="font-semibold text-slate-800">Data Siswa</h3>
            <p class="text-sm text-slate-500">Daftar siswa periode {{ $periodeAktif->nama }}</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left font-medium">No</th>
                        <th class="px-5 py-3 text-left font-medium">Nama Siswa</th>
                        <th class="px-5 py-3 text-left font-medium">NISN</th>
                        <th class="px-5 py-3 text-left font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($siswaList as $i => $s)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $s->nama }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $s->nisn }}</td>
                            <td class="px-5 py-3">
                                @if($s->status === 'sudah_dinilai')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Sudah Dinilai</span>
                                @elseif($s->status === 'sudah_validasi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Sudah Divalidasi</span>
                                @elseif($s->status === 'menunggu')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Menunggu Validasi</span>
                                @elseif($s->status === 'ditolak')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-6 text-center text-slate-500">Belum ada siswa dengan prestasi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @else
        <div class="bg-white rounded-xl shadow-sm border p-6 text-slate-500">Belum ada periode aktif. Hubungi administrator.</div>
    @endif
</x-app-layout>
