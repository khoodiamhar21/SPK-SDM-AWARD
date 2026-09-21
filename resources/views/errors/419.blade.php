<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sesi Berakhir — SDM Award</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 flex items-center justify-center min-h-screen">
    <div class="text-center px-6">
        <div class="text-7xl font-extrabold text-amber-400">419</div>
        <h1 class="text-xl font-semibold text-slate-700 mt-4">Sesi Berakhir</h1>
        <p class="text-slate-500 mt-2">Sesi Anda telah berakhir. Silakan refresh halaman dan login kembali.</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-sm">Login Ulang</a>
    </div>
</body>
</html>