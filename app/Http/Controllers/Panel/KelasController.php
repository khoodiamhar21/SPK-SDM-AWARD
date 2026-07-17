<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('urutan')->get();

        return view('panel.kelas-index', compact('kelas'));
    }

    public function create()
    {
        $k = null;

        return view('panel.kelas-form', compact('k'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:10',
            'urutan' => 'required|integer|min:1|max:6|unique:kelas,urutan',
        ]);
        Kelas::create($data);

        return redirect()->route('panel.kelas.index')->with('success', 'Kelas disimpan.');
    }

    public function edit(Kelas $k)
    {
        return view('panel.kelas-form', compact('k'));
    }

    public function update(Request $request, Kelas $k)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:10',
            'urutan' => 'required|integer|min:1|max:6|unique:kelas,urutan,'.$k->id,
        ]);
        $k->update($data);

        return redirect()->route('panel.kelas.index')->with('success', 'Kelas diperbarui.');
    }

    public function destroy(Kelas $k)
    {
        $k->delete();

        return redirect()->route('panel.kelas.index')->with('success', 'Kelas dihapus.');
    }
}
