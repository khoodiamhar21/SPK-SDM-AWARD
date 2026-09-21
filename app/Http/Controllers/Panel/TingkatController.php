<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class TingkatController extends Controller
{
    public function index()
    {
        $tingkats = Tingkat::with('kriteria')->orderBy('urutan')->get();
        $kriterias = Kriteria::orderBy('kode')->get();

        return view('panel.tingkat-index', compact('tingkats', 'kriterias'));
    }

    public function create()
    {
        $kriterias = Kriteria::orderBy('kode')->get();

        return view('panel.tingkat-form', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:50|unique:tingkats,kode',
            'nama' => 'required|string|max:255',
            'kriteria_id' => 'required|exists:kriterias,id',
            'urutan' => 'required|integer|min:0',
        ]);

        Tingkat::create($data);

        return redirect()->route('panel.tingkat.index')->with('status', 'Tingkat kejuaraan ditambahkan.');
    }

    public function edit(Tingkat $tingkat)
    {
        $kriterias = Kriteria::orderBy('kode')->get();

        return view('panel.tingkat-form', compact('tingkat', 'kriterias'));
    }

    public function update(Request $request, Tingkat $tingkat)
    {
        $data = $request->validate([
            'kode' => 'required|string|max:50|unique:tingkats,kode,'.$tingkat->id,
            'nama' => 'required|string|max:255',
            'kriteria_id' => 'required|exists:kriterias,id',
            'urutan' => 'required|integer|min:0',
        ]);

        $oldKode = $tingkat->kode;
        $tingkat->update($data);

        if ($oldKode !== $data['kode']) {
            \App\Models\Prestasi::where('tingkat', $oldKode)->update(['tingkat' => $data['kode']]);
            \App\Models\Rubrik::where('tingkat', $oldKode)->update(['tingkat' => $data['kode']]);
        }

        return redirect()->route('panel.tingkat.index')->with('status', 'Tingkat kejuaraan diperbarui.');
    }

    public function destroy(Tingkat $tingkat)
    {
        $used = \App\Models\Prestasi::where('tingkat', $tingkat->kode)->count();
        if ($used > 0) {
            return back()->withErrors(['msg' => "Tidak bisa dihapus, masih dipakai {$used} prestasi."]);
        }

        \App\Models\Rubrik::where('tingkat', $tingkat->kode)->delete();
        $tingkat->delete();

        return redirect()->route('panel.tingkat.index')->with('status', 'Tingkat kejuaraan dihapus.');
    }
}
