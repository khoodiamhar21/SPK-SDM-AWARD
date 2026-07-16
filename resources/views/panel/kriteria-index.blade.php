<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">Kriteria & Bobot SAW</h2>
    </x-slot>

    <form method="GET" class="mb-4 flex items-center gap-3">
        <label class="text-sm text-slate-500">Periode:</label>
        <select name="periode_id" onchange="this.form.submit()" class="rounded-md border-slate-300 text-sm">
            @foreach($periodes as $p)
                <option value="{{ $p->id }}" {{ ($periodeId ?? $periodes->first()?->id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
            @endforeach
        </select>
    </form>

    @php
        $periodeId = $periodeId ?? $periodes->first()?->id;
        $total = $kriterias->sum(fn($k) => optional($k->bobots->firstWhere('periode_id', $periodeId))->bobot ?? 0);
    @endphp

    <div class="bg-white rounded-xl shadow-sm border p-6 max-w-2xl">
        <form method="POST" action="{{ route('panel.kriteria.bobot') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="periode_id" value="{{ $periodeId }}">
            @foreach($kriterias as $k)
                @php $b = $k->bobots->firstWhere('periode_id', $periodeId); @endphp
                <div class="flex items-center justify-between gap-4 border-b pb-3">
                    <div>
                        <div class="font-medium">{{ $k->kode }} — {{ $k->nama }}</div>
                        <div class="text-xs text-slate-400">{{ $k->keterangan }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="number" step="0.01" min="0" max="1" name="bobot[{{ $k->id }}]"
                            value="{{ $b->bobot ?? 0 }}" class="w-24 rounded-md border-slate-300 text-right">
                    </div>
                </div>
            @endforeach
            <div class="flex items-center justify-between pt-2">
                <div class="text-sm">Total bobot: <span class="font-semibold {{ abs($total-1) < 0.001 ? 'text-text-blue-600' : 'text-rose-600' }}">{{ number_format($total, 2) }}</span> (harus = 1)</div>
                <x-primary-button>Simpan Bobot</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
