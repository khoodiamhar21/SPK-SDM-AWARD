<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SDM Award — SD Muhammadiyah Metro Pusat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak]{display:none!important}
        .pop{animation:pop .6s cubic-bezier(.34,1.56,.64,1) both}
        @keyframes pop{from{opacity:0;transform:scale(.96) translateY(12px)}to{opacity:1;transform:none}}
        .floaty{animation:floaty 4s ease-in-out infinite}
        @keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-800">

    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white/85 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-5 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logosd.png') }}" class="h-10 w-10 object-contain bg-white rounded-lg p-1" alt="Logo SDM">
                <div class="leading-tight">
                    <div class="font-extrabold text-blue-800 tracking-wide">SDM AWARD</div>
                    <div class="text-[10px] sm:text-[11px] text-slate-400">SD Muhammadiyah Metro Pusat</div>
                </div>
            </div>
            <nav class="hidden sm:flex items-center gap-7 text-sm text-slate-600">
                <a href="#tentang" class="hover:text-blue-700">Tentang</a>
                <a href="#prestasi" class="hover:text-blue-700">Siswa Berprestasi</a>
                <a href="#berita" class="hover:text-blue-700">Berita</a>
                <a href="#pengumuman" class="hover:text-blue-700">Pengumuman</a>
                <a href="#tentang" class="hover:text-blue-700">Tentang</a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl border border-blue-200 text-blue-700 text-sm font-semibold hover:bg-blue-50 transition-all">Register</a>
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition-all shadow-sm">Login</a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    @php
        $heroPhotos = $banners->isNotEmpty()
            ? $banners->map(fn($b) => asset('storage/'.$b->foto_path))->toArray()
            : [asset('img/1aa.jpg'), asset('img/2aa.jpg'), asset('img/5aa.jpg')];
    @endphp
    <section class="relative overflow-hidden" x-data="{ slide: 0, photos: {{ json_encode($heroPhotos) }} }" x-init="setInterval(() => slide = (slide + 1) % photos.length, 4500)">
        <div class="absolute inset-0">
            <template x-for="(p, i) in photos" :key="i">
                <img :src="p" x-show="slide === i" x-transition.opacity.duration.1000ms
                     class="absolute inset-0 h-full w-full object-cover" alt="Kegiatan siswa SD Muhammadiyah Metro Pusat">
            </template>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/85 via-blue-900/65 to-blue-900/10"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-5 py-24 sm:py-32">
            <div class="pop text-white max-w-2xl">
                <span class="inline-block px-3 py-1 rounded-full bg-white/15 text-blue-50 text-xs font-bold mb-5 backdrop-blur">SD Muhammadiyah Metro Pusat</span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight drop-shadow">
                    Apresiasi <span class="text-sky-300">Siswa Berprestasi</span> Kita
                </h1>
                <p class="mt-5 text-blue-50/90 text-lg max-w-lg drop-shadow">
                    SDM Award menyanjung pencapaian terbaik siswa — dari juara kelas hingga prestasi tingkat nasional dan internasional.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-md transition-all">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sambutan / Tentang -->
    <section id="tentang" class="max-w-3xl mx-auto px-5 py-16 text-center">
        <div class="pop">
            <span class="text-blue-600 font-bold text-sm">SAMBUTAN</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Menumbuhkan Semangat Berprestasi</h2>
            <p class="mt-4 text-slate-600 leading-relaxed">
                SDM Award adalah wujud apresiasi SD Muhammadiyah Metro Pusat kepada siswa yang mengharumkan nama sekolah. Melalui penghargaan ini, kami ingin menginspirasi seluruh siswa untuk terus berkarya, berkompetisi secara sehat, dan membanggakan orang tua serta lingkungan.
            </p>
            <p class="mt-3 text-slate-500 text-sm">
                Penilaian dilakukan secara objektif dan transparan dengan sistem pendukung keputusan terintegrasi, sehingga setiap prestasi tercatat dan dihargai setara.
            </p>
        </div>
    </section>

    <!-- Siswa Berprestasi (highlight) -->
    <section id="prestasi" class="bg-gradient-to-br from-blue-50 to-sky-50 border-y border-blue-100">
        <div class="max-w-6xl mx-auto px-5 py-16">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Siswa Berprestasi Kita</h2>
                <p class="text-slate-500 mt-2">Kebanggaan SD Muhammadiyah Metro Pusat</p>
            </div>
            <div class="grid sm:grid-cols-3 lg:grid-cols-5 gap-5 mt-10">
                @forelse($prestasiSiswa as $p)
                    <div class="bg-white rounded-3xl border border-slate-100 p-5 text-center hover:-translate-y-2 hover:shadow-xl transition-all pop">
                        <div class="mx-auto h-24 w-24 rounded-full bg-blue-100 overflow-hidden border-4 border-white shadow mb-3 floaty">
                            <img src="{{ asset($p['foto']) }}" class="h-full w-full object-cover" alt="">
                        </div>
                        <div class="font-bold text-slate-800 leading-tight">{{ $p['nama'] }}</div>
                        <div class="text-[11px] text-blue-600 font-semibold mt-0.5">Kelas {{ $p['kelas'] }}</div>
                        <div class="text-xs text-slate-500 mt-2 leading-snug">{{ $p['prestasi'] }}</div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-slate-400 text-sm">Belum ada data siswa berprestasi.</div>
                @endforelse
            </div>
            <div class="text-center mt-8">
                <a href="#berita" class="inline-block px-5 py-2.5 rounded-xl border border-blue-200 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition-all">Berita & Pengumuman</a>
            </div>
        </div>
    </section>

    <!-- Prestasi Terbaru -->
    <section class="max-w-6xl mx-auto px-5 py-16">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Prestasi Terbaru</h2>
            <p class="text-slate-500 mt-2">Catatan emas dari berbagai ajang</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-10">
            @forelse($prestasiTerbaru as $pr)
                <div class="bg-white rounded-2xl border border-slate-100 p-5 hover:-translate-y-1 hover:shadow-lg transition-all pop">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-12 w-12 rounded-full bg-blue-100 overflow-hidden border-2 border-white shadow shrink-0">
                            <img src="{{ asset($prestasiSiswa->firstWhere('nama', $pr->siswa->nama)['foto'] ?? 'img/default-avatar.png') }}" class="h-full w-full object-cover" alt="">
                        </div>
                        <div class="leading-tight">
                            <div class="font-bold text-slate-800 text-sm">{{ $pr->siswa->nama }}</div>
                            <div class="text-[11px] text-blue-600">Kelas {{ $pr->siswa->kelas }}</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="inline-block px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase">{{ $pr->tingkat }}</span>
                        <span class="inline-block px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold">{{ $pr->peringkat }}</span>
                        <span class="inline-block px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px]">{{ $pr->nama }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-400 text-sm">Belum ada prestasi tercatat.</div>
            @endforelse
        </div>
    </section>

    <!-- Berita -->
    <section id="berita" class="bg-slate-50 border-y border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-16">
            <div class="flex items-end justify-between flex-wrap gap-3">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Berita Sekolah</h2>
                    <p class="text-slate-500 mt-1">Kabar terbaru dari lingkungan sekolah</p>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-10">
                @forelse($beritas as $b)
                    <article class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:-translate-y-1 hover:shadow-lg transition-all pop">
                        <div class="h-36 bg-gradient-to-br from-blue-100 to-sky-100 flex items-center justify-center overflow-hidden">
                            @if($b->foto_path)<img src="{{ asset('storage/'.$b->foto_path) }}" class="h-full w-full object-cover" alt="">@endif
                        </div>
                        <div class="p-4">
                            <span class="inline-block px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold mb-2">{{ $b->kategori }}</span>
                            <h3 class="text-sm font-semibold text-slate-800 leading-snug">{{ $b->judul }}</h3>
                            <p class="text-[11px] text-slate-400 mt-2">{{ $b->tanggal->format('d M Y') }}</p>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center text-slate-400 text-sm">Belum ada berita.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Pengumuman -->
    @if($pengumumans->isNotEmpty())
    <section id="pengumuman" class="max-w-6xl mx-auto px-5 py-16">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Pengumuman</h2>
        <div class="mt-8 grid sm:grid-cols-2 gap-4">
            @foreach($pengumumans as $p)
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 pop">
                    <div class="flex items-center gap-2 text-amber-700 font-semibold text-sm">
                        <x-icon name="doc" class="h-5 w-5" /> {{ $p->judul }}
                    </div>
                    <p class="text-sm text-slate-600 mt-2">{{ $p->isi }}</p>
                    <p class="text-[11px] text-slate-400 mt-2">{{ $p->tanggal->format('d M Y') }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- CTA -->
    <section class="max-w-6xl mx-auto px-5 py-16">
        <div class="rounded-3xl bg-gradient-to-r from-blue-600 to-sky-500 text-center py-12 px-6 pop">
            <h3 class="text-2xl font-extrabold text-white">Siswa SDM? Catatkan Prestasimu</h3>
            <p class="text-blue-50 mt-2">Setiap prestasi adalah kebanggaan sekolah. Yuk jadi bagian dari SDM Award.</p>
        </div>
    </section>

    <footer class="border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-5 py-6 text-sm text-slate-400 flex flex-wrap justify-between gap-2 items-center">
            <span class="flex items-center gap-2"><img src="{{ asset('img/logosd.png') }}" class="h-6 w-6 object-contain" alt=""> © 2026 SD Muhammadiyah Metro Pusat — SDM Award</span>
            <span>Apresiasi Siswa Berprestasi</span>
        </div>
    </footer>
</body>
</html>
