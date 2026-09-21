<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800">Status Seleksi</h2>
            <a href="{{ route('prestasi.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">+ Upload Prestasi</a>
        </div>
    </x-slot>

    @if($periodeAktif)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-5 border">
                <div class="text-sm text-slate-500">Periode</div>
                <div class="text-sm font-semibold">{{ $periodeAktif->nama }}</div>
            </div>
            <div class="bg-gradient-to-br from-blue-600 to-sky-500 rounded-xl shadow-sm p-5 border text-white">
                @if($posisiFinal->isNotEmpty())
                    <div class="text-sm text-blue-50">Nilai Perolehan (SAW)</div>
                    <div class="text-2xl font-bold">{{ number_format($posisiFinal->first()['nilai_akhir'], 4) }}</div>
                    <div class="text-[11px] text-blue-50/90 mt-1">Sudah dihitung & tervalidasi · {{ $posisiFinal->first()['kategori'] }}</div>
                @else
                    <div class="text-sm text-blue-50">Nilai Sementara (SAW)</div>
                    <div class="text-2xl font-bold">{{ $nilai !== null ? number_format($nilai, 4) : '-' }}</div>
                    <div class="text-[11px] text-blue-50/90 mt-1">Belum divalidasi panitia/waka</div>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border">
                <div class="text-sm text-slate-500">Posisi Terbaik</div>
                <div class="text-2xl font-bold text-blue-700">{{ $peringkat ? '#'.$peringkat : '-' }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ $posisiKategori->count() }} kategori diikuti</div>
            </div>
        </div>

        <h3 class="font-semibold text-slate-800 mb-3">Rekap Posisi Seleksi per Kategori</h3>
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 text-left">Kategori Lomba</th>
                            <th class="px-5 py-3 text-left">Posisi</th>
                            <th class="px-5 py-3 text-right">Nilai</th>
                            <th class="px-5 py-3 text-center">Prestasi Valid</th>
                            <th class="px-5 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($posisiKategori as $pos)
                            @php
                                $final = $posisiFinal->get($pos['kategori_lomba_id']);
                                $nilaiTampil = $final['nilai_akhir'] ?? $pos['total_vi'];
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-medium">{{ $pos['kategori'] }}</td>
                                <td class="px-5 py-3 font-bold {{ $pos['peringkat'] == 1 ? 'text-blue-600' : 'text-slate-700' }}">#{{ $pos['peringkat'] }}</td>
                                <td class="px-5 py-3 text-right font-mono">{{ number_format($nilaiTampil, 4) }}</td>
                                <td class="px-5 py-3 text-center">{{ $pos['jumlah_prestasi'] }}</td>
                                <td class="px-5 py-3 text-center">
                                    @if($final)
                                        <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Nilai Perolehan</span>
                                    @else
                                        <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Nilai Sementara</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada posisi seleksi. Pastikan prestasi kamu sudah valid dan dinilai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl border p-6 text-slate-500 mb-6">Belum ada periode aktif.</div>
    @endif

    <h3 class="font-semibold text-slate-800 mb-3">Daftar Prestasi Saya</h3>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Kegiatan</th>
                        <th class="px-5 py-3 text-left">Tingkat</th>
                        <th class="px-5 py-3 text-left">Peringkat</th>
                        <th class="px-5 py-3 text-left">Nilai Rubrik</th>
                        <th class="px-5 py-3 text-left">Tahap</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($prestasis as $p)
                        @php
                            $nr = $p->nilai_rubrik;
                            $tahap = $p->status_validasi == 'valid' ? 'Tervalidasi' : ($p->status_validasi == 'ditolak' ? 'Ditolak' : 'Menunggu validasi');
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium">{{ $p->nama_kegiatan }}</td>
                            <td class="px-5 py-3 capitalize">{{ $p->tingkat }}</td>
                            <td class="px-5 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                            <td class="px-5 py-3 font-mono">{{ $nr ?? '-' }}</td>
                            <td class="px-5 py-3 text-xs">{{ $tahap }}</td>
                            <td class="px-5 py-3">
                                @if($p->status_validasi == 'valid')
                                    <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">Valid</span>
                                @elseif($p->status_validasi == 'ditolak')
                                    <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                @if($p->status_validasi == 'menunggu')
                                    <a href="{{ route('prestasi.edit', $p) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-2">Edit</a>
                                    <form method="POST" action="{{ route('prestasi.destroy', $p) }}" class="inline" onsubmit="return confirm('Hapus prestasi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-rose-600 hover:text-rose-800 text-xs font-semibold">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-6 text-center text-slate-400">Belum ada data prestasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
