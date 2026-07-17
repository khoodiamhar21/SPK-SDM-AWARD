<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Penilaian Prestasi</h1>
            <p class="text-sm text-slate-500">Ceklis/input nilai rubrik untuk prestasi yang sudah lolos validasi berkas.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-blue-50 text-blue-800 text-sm border border-blue-200">{{ session('status') }}</div>
    @endif

    @if($periode)
        @if($belumDinilai > 0)
            <div class="mb-4 px-4 py-3 rounded-xl bg-amber-50 text-amber-800 text-sm border border-amber-200">
                Masih ada {{ $belumDinilai }} prestasi yang belum dinilai. Tombol <b>Generate Ranking</b> baru aktif setelah semua prestasi tervalidasi dinilai.
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
                            <th class="px-5 py-3 text-left">Siswa</th>
                            <th class="px-5 py-3 text-left">Kegiatan</th>
                            <th class="px-5 py-3 text-left">Kriteria</th>
                            <th class="px-5 py-3 text-left">Nilai Rubrik</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($prestasis as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-medium">{{ $p->siswa->nama ?? '-' }}</td>
                                <td class="px-5 py-3">{{ $p->nama_kegiatan }}</td>
                                <td class="px-5 py-3 text-[11px] capitalize">{{ $p->penyelenggara }} / {{ $p->jenis }}<br>{{ $p->tingkat }} / {{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                                <td class="px-5 py-3 font-mono font-semibold {{ $p->nilai_rubrik ? 'text-emerald-600' : 'text-amber-600' }}">{{ $p->nilai_rubrik ?? 'Belum dinilai' }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('panel.penilaian.show', $p) }}" class="text-blue-600 hover:underline">Nilai</a>
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
