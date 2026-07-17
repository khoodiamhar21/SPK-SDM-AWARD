<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Data Siswa</h1>
            <p class="text-sm text-slate-500">Master siswa (NISN). Siswa bisa register jika NISN terdaftar.</p>
        </div>
        <a href="{{ route('panel.siswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Siswa
        </a>
    </div>
    @if(session('success'))<div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">{{ session('success') }}</div>@endif
    <form method="GET" class="mb-4 flex items-center gap-2 text-sm">
        <select name="kelas_id" class="rounded-xl border-slate-300 text-sm" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)<option value="{{ $k->id }}" {{ $kelasId==$k->id ? 'selected' : '' }}>{{ $k->nama }}</option>@endforeach
        </select>
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / NISN..."
               class="rounded-xl border-slate-300 text-sm w-56">
        <button type="submit" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm hover:bg-slate-200">Cari</button>
    </form>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500"><tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">NISN</th><th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Kelas</th><th class="px-4 py-3 text-left">Status Registrasi</th><th class="px-4 py-3 text-left">Prestasi</th><th class="px-4 py-3 text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y">
                @forelse($siswas as $i => $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-400">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-mono">{{ $s->nisn ?: '-' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $s->nama }}</td>
                        <td class="px-4 py-3">{{ $s->kelas?->nama ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($s->user_id)
                                <span class="inline-block px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">Terdaftar</span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-semibold">Belum</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $s->prestasis_count }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('panel.siswa.edit', $s) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('panel.siswa.destroy', $s) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-rose-600 hover:underline">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-slate-500">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
