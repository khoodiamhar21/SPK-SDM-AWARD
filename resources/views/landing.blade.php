<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK SDM Award — SD Muhammadiyah Metro Pusat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    <!-- Nav -->
    <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-5 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2 font-bold text-lg text-blue-700">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white text-sm">SD</span>
                SDM Award
            </div>
            <nav class="hidden sm:flex items-center gap-8 text-sm text-slate-600">
                <a href="#tentang" class="hover:text-blue-700">Tentang</a>
                <a href="#alur" class="hover:text-blue-700">Alur</a>
                <a href="#peringkat" class="hover:text-blue-700">Peringkat</a>
            </nav>
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">Login</a>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-sky-50"></div>
        <div class="relative max-w-6xl mx-auto px-5 py-20 sm:py-28 grid sm:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold mb-5">Sistem Pendukung Keputusan</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 leading-tight">
                    Penentuan <span class="text-blue-600">Siswa Berprestasi</span> yang Objektif & Transparan
                </h1>
                <p class="mt-5 text-slate-600 text-lg max-w-md">
                    SDM Award membantu SD Muhammadiyah Metro Pusat menilai dan meranking siswa berprestasi secara otomatis menggunakan metode <strong>SAW (Simple Additive Weighting)</strong>.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-sm">Masuk Sistem</a>
                    <a href="#alur" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:border-blue-300 hover:text-blue-700">Lihat Alur</a>
                </div>
            </div>
            <div class="relative">
                <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6">
                    <div class="text-sm text-slate-400 mb-1">Periode Aktif</div>
                    <div class="text-lg font-bold text-slate-800 mb-4">{{ $periode->nama ?? '—' }}</div>
                    <div class="space-y-3">
                        @forelse($ranking as $i => $r)
                            <div class="flex items-center gap-3">
                                <span class="h-7 w-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">{{ $i+1 }}</span>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-slate-800">{{ $r['siswa']->nama }}</div>
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
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Tentang SDM Award</h2>
            <p class="mt-4 text-slate-600">
                SDM Award adalah apresiasi bagi siswa berprestasi SD Muhammadiyah Metro Pusat. Sistem ini menggantikan penilaian manual dengan perhitungan terbobot yang adil, cepat, dan terdokumentasi.
            </p>
        </div>
        <div class="grid sm:grid-cols-3 gap-5 mt-10">
            @foreach([['Tingkat Kejuaraan','C1 — kota s.d. internasional'],['Peringkat Juara','C2 — juara 1, 2, 3'],['Metode SAW','Normalisasi + bobot = ranking']] as $f)
                <div class="bg-slate-50 rounded-xl border border-slate-100 p-6">
                    <div class="font-semibold text-blue-700">{{ $f[0] }}</div>
                    <div class="text-sm text-slate-500 mt-1">{{ $f[1] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Alur -->
    <section id="alur" class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-16">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center">Alur Sistem</h2>
            <div class="grid sm:grid-cols-4 gap-5 mt-10">
                @foreach([['1','Siswa Input','Unggah prestasi & sertifikat'],['2','Panitia Validasi','Periksa keabsahan data'],['3','Hitung SAW','Sistem meranking otomatis'],['4','Waka Tetapkan','Penetapan penerima award']] as $s)
                    <div class="bg-white rounded-xl border border-slate-100 p-6 text-center">
                        <div class="mx-auto h-10 w-10 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center mb-3">{{ $s[0] }}</div>
                        <div class="font-semibold text-slate-800">{{ $s[1] }}</div>
                        <div class="text-sm text-slate-500 mt-1">{{ $s[2] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Peringkat -->
    <section id="peringkat" class="max-w-6xl mx-auto px-5 py-16">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 text-center">Peringkat Sementara</h2>
        <div class="mt-8 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
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
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-bold text-blue-600">{{ $i+1 }}</td>
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $r['siswa']->nama }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $r['siswa']->kelas }}</td>
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
        <div class="rounded-2xl bg-blue-600 text-center py-12 px-6">
            <h3 class="text-2xl font-bold text-white">Siap melihat hasil SDM Award?</h3>
            <p class="text-blue-100 mt-2">Masuk untuk mengelola atau melihat prestasi Anda.</p>
            <a href="{{ route('login') }}" class="inline-block mt-5 px-6 py-3 rounded-xl bg-white text-blue-700 font-semibold hover:bg-blue-50">Login Sekarang</a>
        </div>
    </section>

    <footer class="border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-6 text-sm text-slate-400 flex flex-wrap justify-between gap-2">
            <span>© 2026 SD Muhammadiyah Metro Pusat — SPK SDM Award</span>
            <span>Metode SAW · Laravel 13</span>
        </div>
    </footer>
</body>
</html>
