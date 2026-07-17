<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebar: false, collapsed: false }" :class="sidebar ? 'overflow-hidden' : ''">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
            .nav-link { transition: all .2s ease; }
            .nav-link:hover { transform: translateX(4px); }
            .fade-in { animation: fadeIn .5s ease both; }
            @keyframes fadeIn { from { opacity:0; transform:translateY(8px);} to {opacity:1; transform:none;} }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">

        @auth
        <!-- Sidebar (desktop) - collapsible: ikon saja saat tertutup -->
        <aside class="bg-gradient-to-b from-blue-800 to-blue-700 text-white fixed inset-y-0 left-0 z-30 hidden md:flex flex-col transition-all duration-300"
               :class="collapsed ? 'w-20' : 'w-64'">
            <div class="px-4 py-5 border-b border-blue-600/50 flex items-center gap-3" :class="collapsed ? 'justify-center' : ''">
                <img src="{{ asset('img/logosd.png') }}" class="h-10 w-10 object-contain bg-white rounded-lg p-1 shrink-0" alt="Logo SDM">
                <div x-show="!collapsed" x-cloak>
                    <div class="font-extrabold text-base leading-tight">SDM Award</div>
                    <div class="text-[11px] text-blue-200">Siswa Berprestasi</div>
                </div>
            </div>
            <nav class="flex-1 px-3 py-4 space-y-1 text-sm overflow-y-auto">
                <a href="{{ route('dashboard') }}" title="Dashboard" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('dashboard') ? 'bg-white/15 font-semibold' : '' }}">
                    <x-icon name="dashboard" class="h-5 w-5 shrink-0" />
                    <span x-show="!collapsed" x-cloak>Dashboard</span>
                </a>

                @if(auth()->user()->isSiswa())
                    <a href="{{ route('prestasi.create') }}" title="Upload Prestasi" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('prestasi.create') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="plus" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Upload Prestasi</span>
                    </a>
                    <a href="{{ route('prestasi.status') }}" title="Status Seleksi" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('prestasi.status') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="trophy" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Status Seleksi</span>
                    </a>
                @else
                    <a href="{{ route('panel.periode.index') }}" title="Periode" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.periode.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="calendar" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Periode</span>
                    </a>
                    <a href="{{ route('panel.siswa.index') }}" title="Data Siswa" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.siswa.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="user" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Data Siswa</span>
                    </a>
                    <a href="{{ route('panel.kelas.index') }}" title="Kelola Kelas" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.kelas.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="user" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Kelola Kelas</span>
                    </a>
                    <a href="{{ route('panel.validasi.kelas') }}" title="Validasi Sertifikat" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.validasi.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="doc" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Validasi Sertifikat</span>
                    </a>
                    <a href="{{ route('panel.penilaian.kelas') }}" title="Penilaian" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.penilaian.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="scale" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Penilaian</span>
                    </a>
                    <a href="{{ route('panel.rekap.index') }}" title="Rekap Penilaian" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.rekap.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="star" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Rekap Penilaian</span>
                    </a>
                    <a href="{{ route('panel.ranking') }}" title="Ranking" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.ranking') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="trophy" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Ranking</span>
                    </a>

                    <div x-show="!collapsed" x-cloak class="border-t border-blue-600/50 my-2"></div>

                    <a href="{{ route('panel.rubrik.index') }}" title="Rubrik Penilaian" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.rubrik.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="scale" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Rubrik</span>
                    </a>
                    @if(auth()->user()->isPanitia())
                        <a href="{{ route('panel.akun.index') }}" title="Kelola Akun" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.akun.*') ? 'bg-white/15 font-semibold' : '' }}">
                            <x-icon name="user" class="h-5 w-5 shrink-0" />
                            <span x-show="!collapsed" x-cloak>Kelola Akun</span>
                        </a>
                    @endif
                    <a href="{{ route('panel.banner.index') }}" title="Banner" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.banner.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="star" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Banner</span>
                    </a>
                    <a href="{{ route('panel.pengumuman.index') }}" title="Pengumuman" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.pengumuman.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="doc" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Pengumuman</span>
                    </a>
                    <a href="{{ route('panel.berita.index') }}" title="Berita" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.berita.*') ? 'bg-white/15 font-semibold' : '' }}">
                        <x-icon name="doc" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Berita</span>
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}" title="Profil" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10">
                    <x-icon name="user" class="h-5 w-5 shrink-0" />
                    <span x-show="!collapsed" x-cloak>Profil</span>
                </a>
            </nav>
            <div class="px-3 py-4 border-t border-blue-600/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-white/10 hover:bg-rose-500 hover:text-white text-sm font-medium transition-all">
                        <x-icon name="logout" class="h-5 w-5 shrink-0" />
                        <span x-show="!collapsed" x-cloak>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile sidebar -->
        <div x-show="sidebar" x-cloak class="fixed inset-0 z-40 md:hidden">
            <div x-show="sidebar" x-transition.opacity class="absolute inset-0 bg-black/40" @click="sidebar=false"></div>
            <aside x-show="sidebar" x-transition class="absolute inset-y-0 left-0 w-64 bg-gradient-to-b from-blue-800 to-blue-700 text-white flex flex-col">
                <div class="px-5 py-5 border-b border-blue-600/50 flex items-center gap-3">
                    <img src="{{ asset('img/logosd.png') }}" class="h-10 w-10 object-contain bg-white rounded-lg p-1" alt="Logo">
                    <div>
                        <div class="font-extrabold text-base leading-tight">SDM Award</div>
                        <div class="text-[11px] text-blue-200">Siswa Berprestasi</div>
                    </div>
                </div>
                <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                    <a href="{{ route('dashboard') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('dashboard') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="dashboard" class="h-5 w-5" /> Dashboard</a>
                    @if(auth()->user()->isSiswa())
                        <a href="{{ route('prestasi.create') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('prestasi.create') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="plus" class="h-5 w-5" /> Upload Prestasi</a>
                        <a href="{{ route('prestasi.status') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('prestasi.status') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="trophy" class="h-5 w-5" /> Status Seleksi</a>
                    @else
                        <a href="{{ route('panel.kriteria.index') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.kriteria.*') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="scale" class="h-5 w-5" /> Kriteria Bobot</a>
                        <a href="{{ route('panel.siswa.index') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.siswa.*') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="user" class="h-5 w-5" /> Daftar Siswa</a>
                        <a href="{{ route('panel.ranking') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.ranking') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="trophy" class="h-5 w-5" /> Ranking</a>
                        <div class="border-t border-blue-600/50 my-2"></div>
                        @if(auth()->user()->isPanitia())
                            <a href="{{ route('panel.akun.index') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.akun.*') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="user" class="h-5 w-5" /> Kelola Akun</a>
                        @endif
                        <a href="{{ route('panel.banner.index') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.banner.*') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="star" class="h-5 w-5" /> Banner</a>
                        <a href="{{ route('panel.pengumuman.index') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.pengumuman.*') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="doc" class="h-5 w-5" /> Pengumuman</a>
                        <a href="{{ route('panel.berita.index') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 {{ request()->routeIs('panel.berita.*') ? 'bg-white/15 font-semibold' : '' }}"><x-icon name="doc" class="h-5 w-5" /> Berita</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" @click="sidebar=false" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10"><x-icon name="user" class="h-5 w-5" /> Profil</a>
                </nav>
                <div class="px-5 py-4 border-t border-blue-600/50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-white/10 hover:bg-rose-500 text-sm font-medium"><x-icon name="logout" class="h-5 w-5" /> Logout</button>
                    </form>
                </div>
            </aside>
        </div>
        @endauth

        <div class="flex-1 transition-all duration-300 md:ml-64" :class="collapsed ? 'md:ml-20' : ''">
            @auth
            <!-- Topbar -->
            <div class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-100">
                <div class="px-4 sm:px-6 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button @click="sidebar = !sidebar" class="md:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-600"><x-icon name="menu" class="h-6 w-6" /></button>
                        <button @click="collapsed = !collapsed" title="Ciutkan menu" class="hidden md:inline-flex p-2 rounded-lg hover:bg-slate-100 text-slate-600"><x-icon name="menu" class="h-6 w-6" /></button>
                        <img src="{{ asset('img/logosd.png') }}" class="h-9 w-9 object-contain" alt="Logo SDM">
                        <div class="leading-tight">
                            <div class="font-extrabold text-blue-800 text-sm sm:text-base">SDM AWARD</div>
                            <div class="text-[10px] sm:text-[11px] text-slate-400">Sistem Pendukung Keputusan Siswa Berprestasi</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden sm:inline text-sm text-slate-500">{{ auth()->user()->name }}</span>
                        <img src="{{ auth()->user()->avatarUrl() }}" class="h-8 w-8 rounded-full bg-blue-50 object-cover" alt="">
                    </div>
                </div>
            </div>
            @endauth

            @isset($header)
                <header class="bg-white shadow-sm border-b">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 fade-in">
                @if (session('status'))
                    <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
