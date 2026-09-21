<x-app-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Rekap Penilaian per Kategori Lomba</h1>
        <p class="text-sm text-slate-500">Nilai hasil sertifikat yang telah dinilai, dikelompokkan per kategori lomba (cabang lomba).</p>
    </div>

    @if($periode)
        <form method="GET" class="mb-4 flex flex-wrap items-center gap-2 text-sm">
            <select name="jenis" class="rounded-xl border-slate-300 text-sm" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                <option value="akademik" {{ ($filterJenis ?? '') === 'akademik' ? 'selected' : '' }}>Akademik</option>
                <option value="non_akademik" {{ ($filterJenis ?? '') === 'non_akademik' ? 'selected' : '' }}>Non-Akademik</option>
            </select>
            <select name="kelas" class="rounded-xl border-slate-300 text-sm" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ (string) $filterKelas === (string) $k->id ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                @endforeach
            </select>
            <select name="kategori" class="rounded-xl border-slate-300 text-sm" onchange="this.form.submit()">
                <option value="">Semua Kategori Lomba</option>
                @foreach($kategoriList as $k)
                    <option value="{{ $k->id }}" {{ (string) $filterKategori === (string) $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / NIS..."
                   class="rounded-xl border-slate-300 text-sm w-56">
            <button type="submit" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Cari</button>
        </form>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
            <div class="px-5 py-3 border-b bg-slate-50 text-sm font-medium text-slate-600">Periode: {{ $periode->nama }}</div>
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">No.</th>
                        <th class="px-5 py-3 text-left">Kategori Penghargaan</th>
                        <th class="px-5 py-3 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($perKategori as $i => $kat)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-2 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-5 py-2 font-semibold">
                                {{ $kat['nama'] }}
                                @if(($kat['jenis_prestasi'] ?? '') === 'akademik')
                                    <span class="ml-1 px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 text-[10px]">Akademik</span>
                                @else
                                    <span class="ml-1 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 text-[10px]">Non-Akademik</span>
                                @endif
                            </td>
                            <td class="px-5 py-2 text-right font-mono font-semibold text-blue-600">{{ $kat['jumlah'] }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-slate-50 font-semibold">
                        <td class="px-5 py-2" colspan="2">Jumlah Penerima Penghargaan</td>
                        <td class="px-5 py-2 text-right font-mono text-blue-700">{{ $perKategori->sum('jumlah') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @forelse($perKategori as $kat)
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
                <div class="px-5 py-3 border-b bg-slate-50 text-sm font-medium text-slate-600">
                    {{ $kat['nama'] }} <span class="ml-2 text-xs text-slate-400">({{ $kat['jumlah'] }} penerima)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-5 py-3 text-left">No</th>
                                <th class="px-5 py-3 text-left">Nama Siswa</th>
                                <th class="px-5 py-3 text-left">NIS</th>
                                <th class="px-5 py-3 text-left">Kelas</th>
                                <th class="px-5 py-3 text-left">Capaian (Tingkat / Peringkat / Skor)</th>
                                <th class="px-5 py-3 text-right">Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($kat['items'] as $i => $s)
                                <tr class="hover:bg-slate-50 align-top">
                                    <td class="px-5 py-3 text-slate-500">{{ $i + 1 }}</td>
                                    <td class="px-5 py-3 font-semibold">{{ $s['nama'] }}</td>
                                    <td class="px-5 py-3 font-mono text-slate-500">{{ $s['nisn'] ?: '-' }}</td>
                                    <td class="px-5 py-3 text-slate-500">Kelas {{ $s['kelas'] }}</td>
                                    <td class="px-5 py-3">
                                        <div class="space-y-1">
                                            @foreach($s['prestasis'] as $p)
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="font-medium">{{ $p->nama_kegiatan }}</span>
                                                    <span class="text-slate-400 capitalize">({{ $p->tingkat }} / {{ str_replace('juara','J',$p->peringkat) }})</span>
                                                    <span class="ml-auto font-mono font-semibold text-blue-600">{{ number_format($p->nilai_rubrik, 0) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-right font-mono font-bold text-blue-700">{{ number_format($s['total'], 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border p-6 text-slate-500">Tidak ada data sesuai filter/pencarian.</div>
        @endforelse
    @else
        <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
    @endif
</x-app-layout>