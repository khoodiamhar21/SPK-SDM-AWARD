<x-app-layout>
    @if(auth()->user()->isWaka())
        {{-- WAKA: VALIDASI PENILAIAN PER KATEGORI --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Validasi Penilaian</h1>
                <p class="text-sm text-slate-500">Setujui hasil ranking penilaian dari Panitia, per kategori lomba.</p>
            </div>
        </div>

        @if($final)
            {{-- Status bar --}}
            <div class="mb-4 flex items-center gap-3 text-sm flex-wrap">
                <span class="text-slate-500">Periode:</span>
                <span class="font-semibold text-slate-700">{{ $periode->nama }}</span>
                <span class="text-slate-300">|</span>
                @php
                    $semuaKategoriId = collect($final->hasil)->pluck('kategori_lomba_id')->unique()->filter()->values()->toArray();
                    $semuaDiv = $semuaKategoriId && $final->disetujui_kelas && empty(array_diff($semuaKategoriId, $final->disetujui_kelas));
                    $jmlDiv = $final->disetujui_kelas ? count($final->disetujui_kelas) : 0;
                @endphp
                @if($semuaDiv)
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">✓ Semua kategori sudah divalidasi</span>
                @elseif($jmlDiv > 0)
                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">⏳ Validasi per kategori ({{ $jmlDiv }}/{{ count($semuaKategoriId) }})</span>
                @else
                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">⏳ Validasi per kategori</span>
                @endif
                @if($final->diumumkan_at)
                    <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">✓ Diumumkan</span>
                @endif
            </div>

            {{-- Filter kategori + tombol validasi --}}
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('panel.ranking') }}"
                       class="px-3 py-1.5 rounded-full text-sm font-medium border {{ is_null($filterJenis) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Semua</a>
                    <a href="{{ route('panel.ranking', ['jenis' => 'akademik']) }}"
                       class="px-3 py-1.5 rounded-full text-sm font-medium border {{ ($filterJenis ?? '') === 'akademik' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Akademik</a>
                    <a href="{{ route('panel.ranking', ['jenis' => 'non_akademik']) }}"
                       class="px-3 py-1.5 rounded-full text-sm font-medium border {{ ($filterJenis ?? '') === 'non_akademik' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Non-Akademik</a>
                </div>

                @if($filterJenis && $final)
                    @php
                        $jenisKategoriIds = collect($final->hasil)
                            ->filter(fn($r) => ($r['jenis_prestasi'] ?? '') === $filterJenis)
                            ->pluck('kategori_lomba_id')->unique()->filter()->values()->toArray();
                        $sudahDivalidasi = $final->disetujui_kelas ?? [];
                        $belumDivalidasi = array_diff($jenisKategoriIds, $sudahDivalidasi);
                    @endphp
                    @if(count($belumDivalidasi) > 0)
                        @foreach($belumDivalidasi as $katId)
                            <form method="POST" action="{{ route('panel.ranking.setujui-kategori', $final) }}" class="inline">
                                @csrf
                                <input type="hidden" name="kategori_lomba_id" value="{{ $katId }}">
                                <button class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 shadow-sm transition-all whitespace-nowrap">
                                    Validasi {{ \App\Models\KategoriLomba::find($katId)?->nama ?? 'Kategori' }}
                                </button>
                            </form>
                        @endforeach
                    @else
                        <span class="px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">✓ Semua kategori {{ $filterJenis === 'akademik' ? 'Akademik' : 'Non-Akademik' }} sudah divalidasi</span>
                    @endif
                @endif
            </div>

            {{-- Tabel hasil --}}
            @if($final)
                @php
                    $hasilAllWaka = $filterJenis
                        ? collect($final->hasil)->filter(fn($r2) => ($r2['jenis_prestasi'] ?? '') === $filterJenis)->values()
                        : collect($final->hasil);
                    $hasilAkademikWaka = $hasilAllWaka->where('jenis_prestasi', 'akademik')->sortBy('peringkat')->values();
                    $hasilNonAkademikWaka = $hasilAllWaka->where('jenis_prestasi', 'non_akademik')->sortBy('peringkat')->values();
                @endphp

                @if($hasilAkademikWaka->isNotEmpty())
                    <h3 class="font-semibold text-blue-700 mb-2 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs">AKADEMIK</span> Ranking Prestasi Akademik
                    </h3>
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mb-6">
                        <table class="w-full text-sm">
                            <thead class="bg-blue-50 text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 text-left">#</th>
                                    <th class="px-5 py-3 text-left">Kategori Lomba</th>
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">Kelas</th>
                                    <th class="px-5 py-3 text-left">Jml Prestasi</th>
                                    <th class="px-5 py-3 text-right">Nilai Akhir</th>
                                    <th class="px-5 py-3 text-right">Detail SAW</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($hasilAkademikWaka as $r)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-5 py-3 font-bold {{ ($r['peringkat'] ?? 0)===1 ? 'text-blue-600' : '' }}">{{ $r['peringkat'] }}</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold">{{ $r['kategori'] ?? '-' }}</span></td>
                                        <td class="px-5 py-3 font-semibold">{{ $r['nama'] }}</td>
                                        <td class="px-5 py-3 text-slate-500">Kelas {{ is_array($r['kelas']) ? ($r['kelas']['nama'] ?? '?') : $r['kelas'] }}</td>
                                        <td class="px-5 py-3">{{ $r['jumlah_prestasi'] }}</td>
                                        <td class="px-5 py-3 text-right font-mono font-semibold text-blue-600">{{ number_format($r['nilai_akhir'] ?? $r['total_vi'], 2) }}</td>
                                        <td class="px-5 py-3 text-right font-mono text-[11px] text-slate-500">
                                            {{ number_format($r['detail']['C1']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C2']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C3']['x'] ?? 0, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($hasilNonAkademikWaka->isNotEmpty())
                    <h3 class="font-semibold text-emerald-700 mb-2 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs">NON-AKADEMIK</span> Ranking Prestasi Non-Akademik
                    </h3>
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mb-6">
                        <table class="w-full text-sm">
                            <thead class="bg-emerald-50 text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 text-left">#</th>
                                    <th class="px-5 py-3 text-left">Kategori Lomba</th>
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">Kelas</th>
                                    <th class="px-5 py-3 text-left">Jml Prestasi</th>
                                    <th class="px-5 py-3 text-right">Nilai Akhir</th>
                                    <th class="px-5 py-3 text-right">Detail SAW</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($hasilNonAkademikWaka as $r)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-5 py-3 font-bold {{ ($r['peringkat'] ?? 0)===1 ? 'text-emerald-600' : '' }}">{{ $r['peringkat'] }}</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold">{{ $r['kategori'] ?? '-' }}</span></td>
                                        <td class="px-5 py-3 font-semibold">{{ $r['nama'] }}</td>
                                        <td class="px-5 py-3 text-slate-500">Kelas {{ is_array($r['kelas']) ? ($r['kelas']['nama'] ?? '?') : $r['kelas'] }}</td>
                                        <td class="px-5 py-3">{{ $r['jumlah_prestasi'] }}</td>
                                        <td class="px-5 py-3 text-right font-mono font-semibold text-emerald-600">{{ number_format($r['nilai_akhir'] ?? $r['total_vi'], 2) }}</td>
                                        <td class="px-5 py-3 text-right font-mono text-[11px] text-slate-500">
                                            {{ number_format($r['detail']['C1']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C2']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C3']['x'] ?? 0, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($hasilAkademikWaka->isEmpty() && $hasilNonAkademikWaka->isEmpty())
                    <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada hasil.</div>
                @endif
            @else
                <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada hasil.</div>
            @endif
            <p class="text-[11px] text-slate-400 mt-2">Di-generate pada {{ $final->created_at->format('d M Y H:i') }} oleh {{ $final->panitia?->name }}</p>
        @else
            <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada ranking di-generate. Hubungi Panitia untuk melakukan penilaian.</div>
        @endif

    @else
        {{-- PANITIA: RANKING SAW PER KATEGORI --}}
        <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Ranking SAW</h2></x-slot>

        @if($periode)
            <div class="text-sm text-slate-500 mb-4">Periode: <span class="font-semibold text-slate-700">{{ $periode->nama }}</span></div>

            @php
                if ($final) {
                    $semuaKategoriId = collect($final->hasil)->pluck('kategori_lomba_id')->unique()->filter()->values()->toArray();
                    $semuaDiv = $semuaKategoriId && $final->disetujui_kelas && empty(array_diff($semuaKategoriId, $final->disetujui_kelas));
                    $jmlDiv = $final->disetujui_kelas ? count($final->disetujui_kelas) : 0;
                    $jmlTotal = count($semuaKategoriId);
                }
            @endphp

            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('panel.ranking') }}"
                       class="px-3 py-1.5 rounded-full text-sm font-medium border {{ is_null($filterJenis) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Semua</a>
                    <a href="{{ route('panel.ranking', ['jenis' => 'akademik']) }}"
                       class="px-3 py-1.5 rounded-full text-sm font-medium border {{ ($filterJenis ?? '') === 'akademik' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Akademik</a>
                    <a href="{{ route('panel.ranking', ['jenis' => 'non_akademik']) }}"
                       class="px-3 py-1.5 rounded-full text-sm font-medium border {{ ($filterJenis ?? '') === 'non_akademik' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Non-Akademik</a>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('panel.ranking.generate') }}">
                        @csrf
                        <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-sm transition-all">Generate Ranking</button>
                    </form>
                    @if($final && !$final->diumumkan_at)
                        <form method="POST" action="{{ route('panel.ranking.umumkan', $final) }}">
                            @csrf
                            <button class="px-4 py-2 rounded-xl bg-amber-600 text-white text-sm font-semibold hover:bg-amber-700 shadow-sm">Buat Pengumuman</button>
                        </form>
                    @endif
                </div>
            </div>

            @if($final)
                <div class="mb-3 text-sm">
                    @if($final->disetujui_at)
                        <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">✓ Disetujui Waka ({{ $final->disetujuiOleh?->name ?? '-' }}, {{ $final->disetujui_at->format('d M Y H:i') }})</span>
                    @elseif($semuaDiv)
                        <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">✓ Semua kategori ({{ $jmlTotal }}) sudah divalidasi Waka</span>
                    @elseif($jmlTotal > 0)
                        <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">Menunggu validasi Waka ({{ $jmlDiv }}/{{ $jmlTotal }} kategori)</span>
                    @else
                        <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">Menunggu validasi Waka</span>
                    @endif
                    @if($final->diumumkan_at)
                        <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold ml-2">✓ Diumumkan ({{ $final->diumumkan_at->format('d M Y H:i') }})</span>
                    @endif
                </div>
            @endif

            {{-- Hasil Ranking --}}
            @if($final)
                @php
                    $hasilAll = $filterJenis
                        ? collect($final->hasil)->filter(fn($r2) => ($r2['jenis_prestasi'] ?? '') === $filterJenis)->values()
                        : collect($final->hasil);
                    $hasilAkademik = $hasilAll->where('jenis_prestasi', 'akademik')->sortBy('peringkat')->values();
                    $hasilNonAkademik = $hasilAll->where('jenis_prestasi', 'non_akademik')->sortBy('peringkat')->values();
                @endphp

                @if($hasilAkademik->isNotEmpty())
                    <h3 class="font-semibold text-blue-700 mb-2 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs">AKADEMIK</span> Ranking Prestasi Akademik
                    </h3>
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mb-6">
                        <table class="w-full text-sm">
                            <thead class="bg-blue-50 text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 text-left">#</th>
                                    <th class="px-5 py-3 text-left">Kategori Lomba</th>
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">Kelas</th>
                                    <th class="px-5 py-3 text-left">Jml Prestasi</th>
                                    <th class="px-5 py-3 text-right">Nilai Akhir</th>
                                    <th class="px-5 py-3 text-right">Detail SAW (N/P/K)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($hasilAkademik as $r)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-5 py-3 font-bold {{ ($r['peringkat'] ?? 0)===1 ? 'text-blue-600' : '' }}">{{ $r['peringkat'] }}</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold">{{ $r['kategori'] ?? '-' }}</span></td>
                                        <td class="px-5 py-3 font-semibold">{{ $r['nama'] }}</td>
                                        <td class="px-5 py-3 text-slate-500">Kelas {{ is_array($r['kelas']) ? ($r['kelas']['nama'] ?? '?') : $r['kelas'] }}</td>
                                        <td class="px-5 py-3">{{ $r['jumlah_prestasi'] }}</td>
                                        <td class="px-5 py-3 text-right font-mono font-semibold text-blue-600">{{ number_format($r['nilai_akhir'] ?? $r['total_vi'], 2) }}</td>
                                        <td class="px-5 py-3 text-right font-mono text-[11px] text-slate-500">
                                            {{ number_format($r['detail']['C1']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C2']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C3']['x'] ?? 0, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($hasilNonAkademik->isNotEmpty())
                    <h3 class="font-semibold text-emerald-700 mb-2 flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs">NON-AKADEMIK</span> Ranking Prestasi Non-Akademik
                    </h3>
                    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mb-6">
                        <table class="w-full text-sm">
                            <thead class="bg-emerald-50 text-slate-500">
                                <tr>
                                    <th class="px-5 py-3 text-left">#</th>
                                    <th class="px-5 py-3 text-left">Kategori Lomba</th>
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">Kelas</th>
                                    <th class="px-5 py-3 text-left">Jml Prestasi</th>
                                    <th class="px-5 py-3 text-right">Nilai Akhir</th>
                                    <th class="px-5 py-3 text-right">Detail SAW (N/P/K)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($hasilNonAkademik as $r)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-5 py-3 font-bold {{ ($r['peringkat'] ?? 0)===1 ? 'text-emerald-600' : '' }}">{{ $r['peringkat'] }}</td>
                                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold">{{ $r['kategori'] ?? '-' }}</span></td>
                                        <td class="px-5 py-3 font-semibold">{{ $r['nama'] }}</td>
                                        <td class="px-5 py-3 text-slate-500">Kelas {{ is_array($r['kelas']) ? ($r['kelas']['nama'] ?? '?') : $r['kelas'] }}</td>
                                        <td class="px-5 py-3">{{ $r['jumlah_prestasi'] }}</td>
                                        <td class="px-5 py-3 text-right font-mono font-semibold text-emerald-600">{{ number_format($r['nilai_akhir'] ?? $r['total_vi'], 2) }}</td>
                                        <td class="px-5 py-3 text-right font-mono text-[11px] text-slate-500">
                                            {{ number_format($r['detail']['C1']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C2']['x'] ?? 0, 0) }} /
                                            {{ number_format($r['detail']['C3']['x'] ?? 0, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($hasilAkademik->isEmpty() && $hasilNonAkademik->isEmpty())
                    <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada hasil.</div>
                @endif

                <p class="text-[11px] text-slate-400 mt-2">Di-generate pada {{ $final->created_at->format('d M Y H:i') }} oleh {{ $final->panitia?->name }}</p>
            @else
                <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada ranking di-generate. Klik <span class="font-semibold">Generate Ranking</span> untuk menetapkan juara.</div>
            @endif

            {{-- Riwayat Generate --}}
            <h3 class="font-semibold text-slate-700 mt-8 mb-2">Riwayat Generate Ranking</h3>
            <div class="bg-white rounded-2xl shadow-sm border divide-y">
                @forelse($riwayat as $rec)
                    <div class="riwayat-item">
                        <button onclick="toggleRiwayat({{ $rec->id }})"
                                class="w-full px-5 py-3 flex items-center justify-between text-sm hover:bg-slate-50 transition-colors text-left {{ $final && $final->id === $rec->id ? 'bg-blue-50' : '' }}">
                            <div>
                                <span class="font-semibold text-slate-700">{{ $rec->created_at->format('d M Y H:i') }}</span>
                                <span class="text-slate-400"> — {{ $rec->panitia?->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500">{{ count($rec->hasil) }} baris</span>
                                <svg class="w-4 h-4 text-slate-400 riwayat-chevron-{{ $rec->id }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </button>
                        <div id="riwayat-{{ $rec->id }}" class="hidden border-t">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-slate-50 text-slate-500">
                                        <tr>
                                            <th class="px-5 py-2.5 text-left">#</th>
                                            <th class="px-5 py-2.5 text-left">Kategori</th>
                                            <th class="px-5 py-2.5 text-left">Nama</th>
                                            <th class="px-5 py-2.5 text-left">Kelas</th>
                                            <th class="px-5 py-2.5 text-right">Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        @foreach($rec->hasil as $rh)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-5 py-2 font-bold {{ $rh['peringkat']===1 ? 'text-blue-600' : '' }}">{{ $rh['peringkat'] }}</td>
                                                <td class="px-5 py-2 text-xs font-semibold text-indigo-600">{{ $rh['kategori'] ?? '-' }}</td>
                                                <td class="px-5 py-2 font-medium">{{ $rh['nama'] }}</td>
                                                <td class="px-5 py-2 text-slate-500">Kelas {{ is_array($rh['kelas']) ? ($rh['kelas']['nama'] ?? '?') : $rh['kelas'] }}</td>
                                                <td class="px-5 py-2 text-right font-mono font-semibold text-blue-600">{{ number_format($rh['nilai_akhir'] ?? $rh['total_vi'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-6 text-center text-slate-400 text-sm">Belum ada riwayat generate.</div>
                @endforelse
            </div>

            <script>
            function toggleRiwayat(id) {
                var el = document.getElementById('riwayat-' + id);
                var ch = document.querySelector('.riwayat-chevron-' + id);
                if (el.classList.contains('hidden')) {
                    el.classList.remove('hidden');
                    ch.classList.add('rotate-180');
                } else {
                    el.classList.add('hidden');
                    ch.classList.remove('rotate-180');
                }
            }
            </script>
        @else
            <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
        @endif
    @endif
</x-app-layout>