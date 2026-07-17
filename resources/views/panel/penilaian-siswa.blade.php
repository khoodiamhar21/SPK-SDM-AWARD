<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Kelas {{ $kelas->nama }} — Pilih Siswa</h1>
        <a href="{{ route('panel.penilaian.kelas') }}" class="text-sm text-blue-600 hover:underline">← Pilih Kelas</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500"><tr><th class="px-4 py-3 text-left">NISN</th><th class="px-4 py-3 text-left">Nama</th><th class="px-4 py-3 text-right">Aksi</th></tr></thead>
            <tbody class="divide-y">
                @forelse($siswas as $s)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono">{{ $s->nisn }}</td>
                        <td class="px-4 py-3 font-medium">{{ $s->nama }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('panel.penilaian.prestasi', $s) }}" class="text-blue-600 hover:underline">Lihat Prestasi</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada siswa dengan prestasi lolos validasi di periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
