<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Validasi Sertifikat</h1>
            <p class="text-sm text-slate-500">Periksa keabsahan berkas prestasi sebelum dinilai.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-blue-50 text-blue-800 text-sm border border-blue-200">{{ session('status') }}</div>
    @endif

    @if($periode)
        <div class="flex gap-2 mb-4 text-sm">
            @foreach(['menunggu'=>'Menunggu','valid'=>'Lolos','ditolak'=>'Ditolak'] as $k=>$label)
                <a href="{{ route('panel.validasi.index', ['status'=>$k]) }}"
                   class="px-3 py-1.5 rounded-lg {{ $status===$k ? 'bg-blue-600 text-white' : 'bg-white border text-slate-600' }}">
                    {{ $label }} <span class="opacity-70">({{ $counts[$k] }})</span>
                </a>
            @endforeach
        </div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-3 text-left">Siswa</th>
                            <th class="px-5 py-3 text-left">Kegiatan</th>
                            <th class="px-5 py-3 text-left">Tingkat</th>
                            <th class="px-5 py-3 text-left">Peringkat</th>
                            <th class="px-5 py-3 text-left">Berkas</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($prestasis as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-medium">{{ $p->siswa->nama ?? '-' }}</td>
                                <td class="px-5 py-3">{{ $p->nama_kegiatan }}</td>
                                <td class="px-5 py-3 capitalize">{{ $p->tingkat }}</td>
                                <td class="px-5 py-3">{{ str_replace('juara','Juara ',$p->peringkat) }}</td>
                                <td class="px-5 py-3">
                                    @if($p->sertifikat_path)
                                        <a href="{{ route('panel.prestasi.dokumen', $p) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat</a>
                                    @else<span class="text-slate-400 text-xs">-</span>@endif
                                </td>
                                <td class="px-5 py-3">
                                    @if($p->status_validasi=='valid')<span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs">Lolos</span>
                                    @elseif($p->status_validasi=='ditolak')<span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs">Ditolak</span>
                                    @else<span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs">Menunggu</span>@endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('panel.validasi.show', $p) }}" class="text-blue-600 hover:underline">Periksa</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-6 text-center text-slate-400">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $prestasis->links() }}</div>
    @else
        <div class="bg-white rounded-xl border p-6 text-slate-500">Belum ada periode aktif.</div>
    @endif
</x-app-layout>
