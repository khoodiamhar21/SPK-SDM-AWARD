<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK SDM Award — SD Muhammadiyah Metro Pusat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak]{display:none!important}
        .pop{animation:pop .6s cubic-bezier(.34,1.56,.64,1) both}
        @keyframes pop{from{opacity:0;transform:scale(.9) translateY(12px)}to{opacity:1;transform:none}}
        .floaty{animation:floaty 4s ease-in-out infinite}
        @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white/85 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-5 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logosd.png') }}" class="h-10 w-10 object-contain" alt="Logo SDM">
                <div class="leading-tight">
                    <div class="font-extrabold text-blue-800 tracking-wide">SDM AWARD</div>
                    <div class="text-[10px] sm:text-[11px] text-slate-400">Sistem Pendukung Keputusan Siswa Berprestasi</div>
                </div>
            </div>
            <nav class="hidden sm:flex items-center gap-7 text-sm text-slate-600">
                <a href="#tentang" class="hover:text-blue-700">Tentang</a>
                <a href="#berita" class="hover:text-blue-700">Berita</a>
                <a href="#prestasi" class="hover:text-blue-700">Siswa Berprestasi</a>
                <a href="#peringkat" class="hover:text-blue-700">Peringkat</a>
            </nav>
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition-all shadow-sm">Login</a>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <!-- Banner foto kegiatan di belakang -->
        <div class="absolute inset-0">
            <img src="{{ asset('img/1aa.jpg') }}" class="h-full w-full object-cover" alt="Kegiatan prestasi siswa">
            <!-- gradasi ke kanan: kiri gelap (teks), kanan transparan (foto kelihatan) -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/85 via-blue-900/70 to-blue-900/10"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-5 py-24 sm:py-32 grid sm:grid-cols-2 gap-12 items-center">
            <div class="pop text-white">
                <span class="inline-block px-3 py-1 rounded-full bg-white/15 text-blue-50 text-xs font-bold mb-5 backdrop-blur">Sistem Pendukung Keputusan</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight drop-shadow">
                    Rayakan <span class="text-sky-300">Siswa Berprestasi</span> dengan Cara yang Adil & Transparan
                </h1>
                <p class="mt-5 text-blue-50/90 text-lg max-w-md drop-shadow">
                    SDM Award membantu SD Muhammadiyah Metro Pusat menilai dan meranking siswa berprestasi secara otomatis menggunakan metode <strong>SAW (Simple Additive Weighting)</strong>.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-md transition-all">Masuk Sistem</a>
                    <a href="#alur" class="px-6 py-3 rounded-2xl border border-white/40 text-white font-semibold hover:bg-white/10 transition-all">Lihat Alur</a>
                </div>
            </div>
            <div class="pop hidden sm:block" style="animation-delay:.15s">
                <div class="bg-white/95 backdrop-blur rounded-3xl shadow-xl border border-white/40 p-6 floaty">
                    <div class="text-sm text-slate-400 mb-1">Periode Aktif</div>
                    <div class="text-lg font-bold text-slate-800 mb-4">{{ $periode->nama ?? '—' }}</div>
                    <div class="space-y-3">
                        @forelse($ranking as $i => $r)
                            <div class="flex items-center gap-3">
                                <span class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-sky-400 text-white text-xs font-bold flex items-center justify-center shadow">{{ $i+1 }}</span>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-slate-800">{{ $r['siswa']->nama }}</div>
                                    <div class="text-xs text-slate-400">Kelas {{ $r['siswa']->kelas }}</div>
                                </div>
                                <span class="text-sm font-mono text-blue-600">{{ number_format($r['total_vi'], 4) }}</span>
                            </div>
                        @empty
                            <div class="text-sm text-slate-400">Belum ada data peringkat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang -->
    <section id="tentang" class="max-w-6xl mx-auto px-5 py-16">
        <div class="text-center max-w-2xl mx-auto pop">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Tentang SDM Award</h2>
            <p class="mt-4 text-slate-600">
                SDM Award adalah apresiasi bagi siswa berprestasi SD Muhammadiyah Metro Pusat. Sistem ini menggantikan penilaian manual dengan perhitungan terbobot yang adil, cepat, dan terdokumentasi.
            </p>
        </div>
        <div class="grid sm:grid-cols-3 gap-5 mt-10">
            @foreach([['trophy','Tingkat Kejuaraan','C1 — kota s.d. internasional'],['star','Peringkat Juara','C2 — juara 1, 2, 3'],['scale','Metode SAW','Normalisasi + bobot = ranking']] as $f)
                <div class="bg-blue-50/60 rounded-2xl border border-blue-100 p-6 hover:-translate-y-1 transition-transform pop">
                    <div class="mb-2 text-blue-600"><x-icon name="{{ $f[0] }}" class="h-8 w-8" /></div>
                    <div class="font-bold text-blue-700">{{ $f[1] }}</div>
                    <div class="text-sm text-slate-500 mt-1">{{ $f[2] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Alur -->
    <section id="alur" class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-16">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Alur Sistem</h2>
            <div class="grid sm:grid-cols-4 gap-5 mt-10">
                @foreach([['1','doc','Siswa Input','Unggah prestasi & sertifikat'],['2','check','Panitia Validasi','Periksa keabsahan data'],['3','scale','Hitung SAW','Sistem meranking otomatis'],['4','trophy','Waka Tetapkan','Penetapan penerima award']] as $s)
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center hover:shadow-md transition-shadow pop">
                        <div class="mx-auto h-12 w-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center mb-3"><x-icon name="{{ $s[1] }}" class="h-6 w-6" /></div>
                        <div class="text-xs font-bold text-blue-500 mb-1">Langkah {{ $s[0] }}</div>
                        <div class="font-bold text-slate-800">{{ $s[2] }}</div>
                        <div class="text-sm text-slate-500 mt-1">{{ $s[3] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Berita -->
    <section id="berita" class="max-w-6xl mx-auto px-5 py-16">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Berita & Prestasi Terbaru</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-10">
            @foreach($berita as $b)
                <article class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:-translate-y-1 hover:shadow-lg transition-all pop">
                    <div class="h-36 bg-gradient-to-br from-blue-100 to-sky-100 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset($b['foto']) }}" class="h-full w-full object-cover" alt="">
                    </div>
                    <div class="p-4">
                        <span class="inline-block px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold mb-2">{{ $b['kategori'] }}</span>
                        <h3 class="text-sm font-semibold text-slate-800 leading-snug">{{ $b['judul'] }}</h3>
                        <p class="text-[11px] text-slate-400 mt-2">{{ $b['tanggal'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <!-- Siswa Berprestasi -->
    <section id="prestasi" class="bg-gradient-to-br from-blue-50 to-sky-50 border-y border-blue-100">
        <div class="max-w-6xl mx-auto px-5 py-16">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Siswa Berprestasi Kita</h2>
            <p class="text-center text-slate-500 mt-2">Kebanggaan SD Muhammadiyah Metro Pusat</p>
            <div class="grid sm:grid-cols-3 gap-6 mt-10">
                @foreach($prestasiSiswa as $p)
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 text-center hover:-translate-y-2 hover:shadow-xl transition-all pop">
                        <div class="mx-auto h-24 w-24 rounded-full bg-blue-100 overflow-hidden border-4 border-white shadow mb-4 floaty">
                            <img src="{{ asset($p['foto']) }}" class="h-full w-full object-cover" alt="">
                        </div>
                        <div class="font-bold text-slate-800">{{ $p['nama'] }}</div>
                        <div class="text-xs text-blue-600 font-semibold mb-2">Kelas {{ $p['kelas'] }}</div>
                        <div class="text-sm text-slate-500">{{ $p['prestasi'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Peringkat -->
    <section id="peringkat" class="max-w-6xl mx-auto px-5 py-16">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Peringkat Sementara</h2>
        <div class="mt-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">#</th>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">Kelas</th>
                        <th class="px-5 py-3 text-right">Nilai Vi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($ranking as $i => $r)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3 font-bold text-blue-600">{{ $i+1 }}</td>
                            <td class="px-5 py-3 font-semibold text-slate-800">{{ $r['siswa']->nama }}</td>
                            <td class="px-5 py-3 text-slate-500">Kelas {{ $r['siswa']->kelas }}</td>
                            <td class="px-5 py-3 text-right font-mono text-slate-700">{{ number_format($r['total_vi'], 4) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-slate-400">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- CTA -->
    <section class="max-w-6xl mx-auto px-5 pb-20">
        <div class="rounded-3xl bg-gradient-to-r from-blue-600 to-sky-500 text-center py-12 px-6 pop">
            <h3 class="text-2xl font-extrabold text-white">Siap melihat hasil SDM Award?</h3>
            <p class="text-blue-50 mt-2">Masuk untuk mengelola atau melihat prestasi Anda.</p>
            <a href="{{ route('login') }}" class="inline-block mt-5 px-6 py-3 rounded-2xl bg-white text-blue-700 font-bold hover:bg-blue-50 transition-all">Login Sekarang</a>
        </div>
    </section>

    <footer class="border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-6 text-sm text-slate-400 flex flex-wrap justify-between gap-2 items-center">
            <span class="flex items-center gap-2"><img src="{{ asset('img/logosd.png') }}" class="h-6 w-6 object-contain" alt=""> © 2026 SD Muhammadiyah Metro Pusat — SPK SDM Award</span>
            <span>Metode SAW · Laravel 13</span>
        </div>
    </footer>
</body>
</html>
