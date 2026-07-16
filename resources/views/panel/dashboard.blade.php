<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Dashboard Panitia</h2>
    </x-slot>

    @if($periodeAktif)
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border">
            <div class="text-sm text-slate-500">Periode Aktif</div>
            <div class="text-lg font-semibold text-text-blue-600">{{ $periodeAktif->nama }}</div>
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

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">Hasil Ranking SAW (otomatis)</h3>
            <a href="{{ route('panel.prestasi.index') }}" class="text-sm text-text-blue-600 hover:underline">Kelola Validasi →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Peringkat</th>
                        <th class="px-5 py-3 text-left">Nama Siswa</th>
                        <th class="px-5 py-3 text-left">Kelas</th>
                        <th class="px-5 py-3 text-left">Jml Prestasi</th>
                        <th class="px-5 py-3 text-right">Nilai Vi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($ranking as $i => $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-bold {{ $i === 0 ? 'text-text-blue-600' : '' }}">#{{ $i + 1 }}</td>
                            <td class="px-5 py-3 font-medium">{{ $r['siswa']->nama }}</td>
                            <td class="px-5 py-3">{{ $r['siswa']->kelas }}</td>
                            <td class="px-5 py-3">{{ $r['jumlah_prestasi'] }}</td>
                            <td class="px-5 py-3 text-right font-mono">{{ number_format($r['total_vi'], 4) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada prestasi tervalidasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border p-6 text-slate-500">Belum ada periode aktif. Hubungi administrator.</div>
    @endif
</x-app-layout>
