<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pengumuman->judul }} — SDM Award</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .pop{animation:pop .6s cubic-bezier(.34,1.56,.64,1) both}
        @keyframes pop{from{opacity:0;transform:scale(.96) translateY(12px)}to{opacity:1;transform:none}}
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    <header class="sticky top-0 z-20 bg-white/85 backdrop-blur border-b border-slate-100">
        <div class="max-w-5xl mx-auto px-5 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logosd.png') }}" class="h-10 w-10 object-contain bg-white rounded-lg p-1" alt="Logo SDM">
                <div class="leading-tight">
                    <div class="font-extrabold text-blue-800 tracking-wide">SDM AWARD</div>
                    <div class="text-[10px] sm:text-[11px] text-slate-400">SD Muhammadiyah Metro Pusat</div>
                </div>
            </div>
            <a href="{{ route('landing') }}" class="text-sm text-slate-500 hover:text-blue-700">&larr; Beranda</a>
        </div>
    </header>

    <section class="max-w-5xl mx-auto px-5 py-10">
        <div class="mt-4 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">{{ $pengumuman->judul }}</h1>
                <div class="text-sm text-slate-400 mt-1">{{ $pengumuman->tanggal->format('d M Y') }}</div>
            </div>
            @if($pengumuman->data)
                <a href="{{ route('pengumuman.pdf', $pengumuman) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-sm shrink-0">Download PDF (Semua Kategori)</a>
            @endif
        </div>

        @if($pengumuman->data)
            @if($kategoriList->count() > 1)
                <div class="flex flex-wrap gap-2 mt-6 pop">
                    <a href="{{ route('pengumuman.show', $pengumuman) }}"
                       class="px-3 py-1.5 rounded-full text-xs font-semibold border {{ request()->query('kategori') ? 'bg-white text-slate-600 border-slate-200 hover:border-blue-300' : 'bg-blue-600 text-white border-blue-600' }}">
                        Semua Kategori
                    </a>
                    @foreach($kategoriList as $nama)
                        <a href="{{ route('pengumuman.show', ['pengumuman' => $pengumuman, 'kategori' => $nama]) }}"
                           class="px-3 py-1.5 rounded-full text-xs font-semibold border {{ request()->query('kategori') === $nama ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-300' }}">
                            {{ $nama }}
                        </a>
                    @endforeach
                </div>
            @endif

            @forelse($perKategori as $namaKategori => $rows)
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mt-6 pop">
                    <div class="px-5 py-3 bg-slate-50 border-b font-semibold text-slate-700 flex items-center justify-between gap-3">
                        <span>Kategori: {{ $namaKategori }}</span>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-slate-400 font-normal">{{ $rows->count() }} peserta</span>
                            <a href="{{ route('pengumuman.pdf', ['pengumuman' => $pengumuman, 'kategori' => $namaKategori]) }}"
                               class="text-xs font-semibold text-blue-600 hover:underline">Download PDF</a>
                        </div>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="text-slate-500">
                            <tr>
                                <th class="px-5 py-3 text-left w-12">No</th>
                                <th class="px-5 py-3 text-left w-24">Peringkat</th>
                                <th class="px-5 py-3 text-left">Nama</th>
                                <th class="px-5 py-3 text-left w-28">Kelas</th>
                                <th class="px-5 py-3 text-right w-32">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($rows as $row)
                                <tr class="hover:bg-slate-50 align-top">
                                    <td class="px-5 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-bold {{ $row['peringkat'] == 1 ? 'text-blue-600' : '' }}">{{ $row['peringkat'] }}</td>
                                    <td class="px-5 py-3 font-medium">
                                        {{ $row['nama'] }}
                                        @if(!empty($row['detail']))
                                            <details class="mt-1">
                                                <summary class="text-xs text-blue-600 cursor-pointer select-none font-semibold">Detail Penilaian</summary>
                                                <div class="overflow-x-auto mt-2">
                                                    <table class="w-full text-xs border rounded-lg overflow-hidden">
                                                        <thead class="bg-slate-100 text-slate-500">
                                                            <tr>
                                                                <th class="px-2 py-1.5 text-left">Kriteria</th>
                                                                <th class="px-2 py-1.5 text-right">Nilai (X)</th>
                                                                <th class="px-2 py-1.5 text-right">Normalisasi</th>
                                                                <th class="px-2 py-1.5 text-right">Bobot</th>
                                                                <th class="px-2 py-1.5 text-right">Kontribusi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-slate-100">
                                                            @foreach($row['detail'] as $kode => $d)
                                                                <tr>
                                                                    <td class="px-2 py-1.5 font-semibold">{{ $kode }}</td>
                                                                    <td class="px-2 py-1.5 text-right font-mono">{{ $d['x'] }}</td>
                                                                    <td class="px-2 py-1.5 text-right font-mono">{{ $d['rnorm'] }}</td>
                                                                    <td class="px-2 py-1.5 text-right font-mono">{{ $d['w'] }}</td>
                                                                    <td class="px-2 py-1.5 text-right font-mono">{{ $d['kontrib'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </details>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">{{ $row['kelas'] ?? '-' }}</td>
                                    <td class="px-5 py-3 text-right font-mono">{{ $row['nilai_akhir'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border p-6 mt-6 text-sm text-slate-500">Data tidak ditemukan untuk kategori ini.</div>
            @endforelse
        @else
            <div class="bg-white rounded-2xl shadow-sm border p-6 mt-6 text-sm text-slate-600 whitespace-pre-line">{{ $pengumuman->isi }}</div>
        @endif
    </section>

    <footer class="border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-6 text-sm text-slate-400 text-center">
            &copy; {{ date('Y') }} SD Muhammadiyah Metro Pusat. All rights reserved.
        </div>
    </footer>

</body>
</html>
