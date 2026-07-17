<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Rekap Penilaian</h1>
        <p class="text-sm text-slate-500">Nilai hasil dari sertifikat yang telah dinilai, per siswa.</p>
    </div>

    @if($periode)
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="px-5 py-3 border-b bg-slate-50 text-sm font-medium text-slate-600">Periode: {{ $periode->nama }}</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 text-left">No</th>
                            <th class="px-5 py-3 text-left">Nama Siswa</th>
                            <th class="px-5 py-3 text-left">Kelas</th>
                            <th class="px-5 py-3 text-left">Daftar Nilai Sertifikat (Tingkat / Peringkat)</th>
                            <th class="px-5 py-3 text-right">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($siswas as $i => $s)
                            @php $total = $s->prestasis->sum('nilai_rubrik'); @endphp
                            <tr class="hover:bg-slate-50 align-top">
                                <td class="px-5 py-3 text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3 font-semibold">{{ $s->nama }}</td>
                                <td class="px-5 py-3 text-slate-500">Kelas {{ $s->kelas }}</td>
                                <td class="px-5 py-3">
                                    <div class="space-y-1">
                                        @foreach($s->prestasis as $p)
                                            <div class="flex items-center gap-2 text-xs">
                                                <span class="font-medium">{{ $p->nama_kegiatan }}</span>
                                                <span class="text-slate-400 capitalize">({{ $p->tingkat }} / {{ str_replace('juara','J',$p->peringkat) }})</span>
                                                <span class="ml-auto font-mono font-semibold text-blue-600">{{ number_format($p->nilai_rubrik, 0) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-right font-mono font-bold text-blue-700">{{ number_format($total, 0) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada siswa yang dinilai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
    @endif
</x-app-layout>
