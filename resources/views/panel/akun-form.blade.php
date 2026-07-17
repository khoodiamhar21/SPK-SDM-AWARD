<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800">{{ $user ? 'Edit Akun' : 'Akun Baru' }}</h2>
            <a href="{{ route('panel.akun.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    @if(session('status'))
        <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ $user ? route('panel.akun.update', $user) : route('panel.akun.store') }}" class="bg-white rounded-xl shadow-sm border p-6 max-w-lg space-y-4">
        @csrf
        @if($user) @method('patch') @endif

        <div>
            <label class="text-sm text-slate-600">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="mt-1 block w-full rounded-md border-slate-300" required>
        </div>
        <div>
            <label class="text-sm text-slate-600">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="mt-1 block w-full rounded-md border-slate-300" required>
        </div>
        <div>
            <label class="text-sm text-slate-600">Role</label>
            <select name="role" class="mt-1 block w-full rounded-md border-slate-300">
                <option value="panitia" {{ old('role', $user->role ?? '') == 'panitia' ? 'selected' : '' }}>Panitia</option>
                <option value="wakasiswa" {{ old('role', $user->role ?? '') == 'wakasiswa' ? 'selected' : '' }}>Waka Kesiswaan</option>
                <option value="siswa" {{ old('role', $user->role ?? '') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>
        <div>
            <label class="text-sm text-slate-600">Password {{ $user ? '(kosongkan jika tidak diubah)' : '' }}</label>
            <input type="password" name="password" class="mt-1 block w-full rounded-md border-slate-300" @if(!$user) required @endif>
        </div>
        <div>
            <label class="text-sm text-slate-600">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-slate-300">
        </div>

        <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Simpan</button>
    </form>
</x-app-layout>
