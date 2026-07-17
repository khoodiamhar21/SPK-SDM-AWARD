<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Ranking SAW</h2></x-slot>

    @if($periode)
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div class="text-sm text-slate-500">Periode: <span class="font-semibold text-slate-700">{{ $periode->nama }}</span></div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->isPanitia())
                <form method="POST" action="{{ route('panel.ranking.generate') }}">
                    @csrf
                    <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-sm transition-all">Generate Ranking</button>
                </form>
                @endif
                @if($final && !$final->disetujui_at && auth()->user()->isWaka())
                    <form method="POST" action="{{ route('panel.ranking.setujui', $final) }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 shadow-sm">Setujui Hasil</button>
                    </form>
                @endif
                @if($final && $final->disetujui_at && !$final->diumumkan_at && auth()->user()->isPanitia())
                    <form method="POST" action="{{ route('panel.ranking.umumkan', $final) }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-700 shadow-sm">Umumkan Hasil</button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('status'))
            <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @if($final)
            <div class="mb-3 text-sm">
                @if($final->disetujui_at)
                    <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">✓ Disetujui Waka ({{ $final->disetujui_oleh ? $final->disetujui_oleh->name : '-' }}, {{ $final->disetujui_at->format('d M Y H:i') }})</span>
                @else
                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">Menunggu persetujuan Waka</span>
                @endif
                @if($final->diumumkan_at)
                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold ml-2">✓ Diumumkan ({{ $final->diumumkan_at->format('d M Y H:i') }})</span>
                @endif
            </div>
        @endif

        <!-- Hasil generate terakhir (final) -->
        <h3 class="font-semibold text-slate-700 mb-2">Hasil Ranking (Final)</h3>
        @if($final)
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 text-left">#</th>
                            <th class="px-5 py-3 text-left">Nama</th>
                            <th class="px-5 py-3 text-left">Kelas</th>
                            <th class="px-5 py-3 text-left">Jml Prestasi</th>
                            <th class="px-5 py-3 text-right">Nilai Akhir</th>
                            <th class="px-5 py-3 text-right">Detail SAW (N/P/K)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($final->hasil as $r)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-bold {{ $r['peringkat']===1 ? 'text-blue-600' : '' }}">{{ $r['peringkat'] }}</td>
                                <td class="px-5 py-3 font-semibold">{{ $r['nama'] }}</td>
                                <td class="px-5 py-3 text-slate-500">Kelas {{ $r['kelas'] }}</td>
                                <td class="px-5 py-3">{{ $r['jumlah_prestasi'] }}</td>
                                <td class="px-5 py-3 text-right font-mono font-semibold text-blue-600">{{ number_format($r['nilai_akhir'] ?? $r['total_vi'], 2) }}</td>
                                <td class="px-5 py-3 text-right font-mono text-[11px] text-slate-500">
                                    {{ number_format($r['detail']['C1']['x'] ?? 0, 0) }} /
                                    {{ number_format($r['detail']['C2']['x'] ?? 0, 0) }} /
                                    {{ number_format($r['detail']['C3']['x'] ?? 0, 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada hasil.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">Di-generate pada {{ $final->created_at->format('d M Y H:i') }} oleh {{ $final->panitia->name }}</p>
        @else
            <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada ranking di-generate. Klik <span class="font-semibold">Generate Ranking</span> untuk menetapkan juara.</div>
        @endif

        <!-- Riwayat generate -->
        <h3 class="font-semibold text-slate-700 mt-8 mb-2">Riwayat Generate</h3>
        <div class="bg-white rounded-2xl shadow-sm border divide-y">
            @forelse($riwayat as $rec)
                <div class="px-5 py-3 flex items-center justify-between text-sm">
                    <div>
                        <span class="font-semibold text-slate-700">{{ $rec->created_at->format('d M Y H:i') }}</span>
                        <span class="text-slate-400"> — {{ $rec->panitia->name }}</span>
                    </div>
                    <span class="text-slate-500">{{ count($rec->hasil) }} peserta</span>
                </div>
            @empty
                <div class="px-5 py-6 text-center text-slate-400 text-sm">Belum ada riwayat generate.</div>
            @endforelse
        </div>
    @else
        <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
    @endif
</x-app-layout>
