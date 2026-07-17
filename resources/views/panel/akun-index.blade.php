<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800">Kelola Akun</h2>
            <a href="{{ route('panel.akun.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">+ Akun Baru</a>
        </div>
    </x-slot>

    @if(session('status'))
        <div class="mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 text-sm">{{ session('status') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Role</th>
                        <th class="px-5 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium">{{ $u->name }}</td>
                            <td class="px-5 py-3">{{ $u->email }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-600 text-xs capitalize">{{ $u->role }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('panel.akun.edit', $u) }}" class="text-blue-600 hover:underline text-xs">Edit</a>
                                    @if($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('panel.akun.destroy', $u) }}" onsubmit="return confirm('Hapus akun ini?')">
                                            @csrf @method('delete')
                                            <button class="text-rose-600 hover:underline text-xs">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-slate-400">Tidak ada akun.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
