<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Penilaian Prestasi</h1>
            <p class="text-sm text-slate-500">Nilai otomatis dari rubrik saat prestasi divalidasi validator.</p>
        </div>
    </div>

    @if($periode)
        @if($belumDinilai > 0)
            <div class="mb-4 px-4 py-3 rounded-xl bg-amber-50 text-amber-800 text-sm border border-amber-200">
                Masih ada {{ $belumDinilai }} prestasi belum dinilai (menunggu validasi).
            </div>
        @else
            <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-800 text-sm border border-emerald-200">
                Semua prestasi periode ini sudah dinilai. Generate Ranking dapat dilakukan.
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 text-left">#</th>
                            <th class="px-5 py-3 text-left">Siswa</th>
                            <th class="px-5 py-3 text-left">Kegiatan</th>
                            <th class="px-5 py-3 text-left">Kriteria</th>
                            <th class="px-5 py-3 text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($prestasis as $i => $p)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 text-slate-400">{{ ($prestasis->currentPage()-1)*$prestasis->perPage()+$i+1 }}</td>
                                <td class="px-5 py-3 font-medium">{{ $p->siswa->nama ?? '-' }}</td>
                                <td class="px-5 py-3">{{ $p->nama_kegiatan }}</td>
                                <td class="px-5 py-3 text-[11px] capitalize">{{ $p->kategoriLomba->nama ?? '-' }} / {{ $p->jenis }}<br>{{ $p->tingkat }} / {{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                                <td class="px-5 py-3 text-center">
                                    @if($p->nilai_rubrik)
                                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-mono font-bold text-xs">{{ $p->nilai_rubrik }}</span>
                                    @else
                                        <span class="text-slate-400 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada prestasi lolos validasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $prestasis->links() }}</div>
    @else
        <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
    @endif
</x-app-layout>
