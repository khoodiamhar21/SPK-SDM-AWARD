<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Prestasi: {{ $siswa->nama }}</h1>
        <a href="{{ route('panel.validasi.siswa', $siswa->kelas_id) }}" class="text-sm text-blue-600 hover:underline">← Pilih Siswa</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500"><tr>
                <th class="px-4 py-3 text-left">Kegiatan</th><th class="px-4 py-3 text-left">Tingkat</th>
                <th class="px-4 py-3 text-left">Peringkat</th><th class="px-4 py-3 text-left">Berkas</th>
                <th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Aksi</th>
            </tr></thead>
            <tbody class="divide-y">
                @forelse($prestasis as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium">{{ $p->nama_kegiatan }}</td>
                        <td class="px-4 py-3 capitalize">{{ $p->tingkat }}</td>
                        <td class="px-4 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                        <td class="px-4 py-3">@if($p->sertifikat_path)<a href="{{ route('panel.prestasi.dokumen', $p) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat</a>@else - @endif</td>
                        <td class="px-4 py-3">
                            @if($p->status_validasi=='valid')<span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Lolos</span>
                            @elseif($p->status_validasi=='ditolak')<span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                            @else<span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>@endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($p->status_validasi=='menunggu')
                                <div class="flex gap-2 justify-end">
                                    <form method="POST" action="{{ route('panel.prestasi.validasi', $p) }}">@csrf<input type="hidden" name="status_validasi" value="valid"><button class="px-2 py-1 rounded-lg bg-emerald-600 text-white text-[11px] hover:bg-emerald-700">Valid</button></form>
                                    <form method="POST" action="{{ route('panel.prestasi.validasi', $p) }}">@csrf<input type="hidden" name="status_validasi" value="ditolak"><button class="px-2 py-1 rounded-lg bg-rose-500 text-white text-[11px] hover:bg-rose-600">Tolak</button></form>
                                </div>
                            @else
                                <a href="{{ route('panel.validasi.show', $p) }}" class="text-blue-600 hover:underline text-xs">Detail</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-slate-500">Belum ada prestasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
