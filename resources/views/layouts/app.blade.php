<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        <div class="min-h-screen flex">
            @auth
            <aside class="w-64 bg-blue-700 text-blue-50 hidden md:flex flex-col fixed inset-y-0">
                <div class="px-5 py-5 border-b border-blue-600">
                    <div class="font-bold text-lg leading-tight">SDM Award</div>
                    <div class="text-xs text-blue-200">SPK Siswa Berprestasi</div>
                </div>
                <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">Dashboard</a>

                    @if(auth()->user()->isSiswa())
                        <a href="{{ route('prestasi.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600 {{ request()->routeIs('prestasi.*') ? 'bg-blue-600' : '' }}">Prestasi Saya</a>
                        <a href="{{ route('prestasi.create') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">+ Input Prestasi</a>
                    @else
                        <a href="{{ route('panel.prestasi.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600 {{ request()->routeIs('panel.prestasi.*') ? 'bg-blue-600' : '' }}">Validasi Prestasi</a>
                        <a href="{{ route('panel.kriteria.index') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600 {{ request()->routeIs('panel.kriteria.*') ? 'bg-blue-600' : '' }}">Kriteria & Bobot</a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-600">Profil</a>
                </nav>
                <div class="px-5 py-4 border-t border-blue-600 text-xs text-blue-200">
                    {{ auth()->user()->name }}<br>{{ ucfirst(auth()->user()->role) }}
                </div>
            </aside>
            @endauth

            <div class="flex-1 md:ml-64">
                @auth
                <div class="md:hidden bg-blue-700 text-blue-50 px-4 py-3 flex items-center justify-between">
                    <span class="font-bold">SDM Award</span>
                    <span class="text-xs">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
                @endauth

                @isset($header)
                    <header class="bg-white shadow-sm border-b">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @if (session('status'))
                        <div class="mb-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
