<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Penilaian Prestasi: {{ $siswa->nama }}</h1>
        <a href="{{ route('panel.penilaian.siswa', $siswa->kelas_id) }}" class="text-sm text-blue-600 hover:underline">← Pilih Siswa</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500"><tr>
                <th class="px-4 py-3 text-left">Kegiatan</th><th class="px-4 py-3 text-left">Tingkat</th>
                <th class="px-4 py-3 text-left">Peringkat</th><th class="px-4 py-3 text-left">Nilai</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y">
                @forelse($prestasis as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium">{{ $p->nama_kegiatan }}</td>
                        <td class="px-4 py-3 capitalize">{{ $p->tingkat }}</td>
                        <td class="px-4 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                        <td class="px-4 py-3">
                            @if(is_null($p->nilai_rubrik))<span class="px-2 py-1 rounded-full bg-slate-100 text-slate-500 text-xs">Belum dinilai</span>
                            @else<span class="font-semibold text-blue-700">{{ $p->nilai_rubrik }}</span>@endif
                        </td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('panel.penilaian.show', $p) }}" class="text-blue-600 hover:underline text-xs">Input Nilai</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada prestasi lolos validasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
