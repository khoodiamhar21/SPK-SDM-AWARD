<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Daftar Siswa</h2></x-slot>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-left">NIS</th>
                        <th class="px-5 py-3 text-left">Kelas</th>
                        <th class="px-5 py-3 text-center">Jumlah Prestasi</th>
                        <th class="px-5 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($siswas as $s)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3 font-semibold text-slate-800">{{ $s->nama }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $s->nis }}</td>
                            <td class="px-5 py-3 text-slate-500">Kelas {{ $s->kelas }}</td>
                            <td class="px-5 py-3 text-center">
                                <span class="inline-block px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ $s->prestasis_count }}</span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('panel.siswa.show', $s) }}" class="text-blue-600 hover:underline text-sm font-medium">Lihat prestasi →</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">Belum ada data siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
