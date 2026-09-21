<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-slate-800">Log Aktivitas</h2></x-slot>

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Waktu</th>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Role</th>
                        <th class="px-5 py-3 text-left">Aksi</th>
                        <th class="px-5 py-3 text-left">Keterangan</th>
                        <th class="px-5 py-3 text-left">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 text-slate-500 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                            <td class="px-5 py-3 font-medium">{{ $log->user?->name ?? '-' }}</td>
                            <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100">{{ $log->role ?? '-' }}</span></td>
                            <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium 
                                @if(str_contains($log->action, 'gagal')) bg-red-100 text-red-700
                                @elseif(str_contains($log->action, 'delete')) bg-rose-100 text-rose-700
                                @elseif(str_contains($log->action, 'create') || str_contains($log->action, 'generate')) bg-blue-100 text-blue-700
                                @else bg-slate-100 text-slate-700
                                @endif
                            ">{{ $log->action }}</span></td>
                            <td class="px-5 py-3 text-slate-600 max-w-xs truncate">{{ $log->description }}</td>
                            <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $log->ip ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-6 text-center text-slate-400">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>