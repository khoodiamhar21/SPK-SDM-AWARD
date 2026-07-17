<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::orderByDesc('tahun')->get();

        return view('panel.periode-index', compact('periodes'));
    }

    public function create()
    {
        $periode = null;

        return view('panel.periode-form', compact('periode'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|digits:4',
            'tgl_buka' => 'nullable|date',
            'tgl_tutup' => 'nullable|date',
            'aktif' => 'boolean',
        ]);

        if (! empty($data['aktif'])) {
            Periode::where('aktif', true)->update(['aktif' => false]);
        }

        Periode::create($data);

        return redirect()->route('panel.periode.index')->with('success', 'Periode disimpan.');
    }

    public function edit(Periode $periode)
    {
        return view('panel.periode-form', compact('periode'));
    }

    public function update(Request $request, Periode $periode)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|digits:4',
            'tgl_buka' => 'nullable|date',
            'tgl_tutup' => 'nullable|date',
            'aktif' => 'boolean',
        ]);

        if (! empty($data['aktif'])) {
            Periode::where('aktif', true)->where('id', '!=', $periode->id)->update(['aktif' => false]);
        }

        $periode->update($data);

        return redirect()->route('panel.periode.index')->with('success', 'Periode diperbarui.');
    }

    public function destroy(Periode $periode)
    {
        $periode->delete();

        return redirect()->route('panel.periode.index')->with('success', 'Periode dihapus.');
    }
}
