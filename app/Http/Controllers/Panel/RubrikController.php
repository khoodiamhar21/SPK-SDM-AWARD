<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Rubrik;
use Illuminate\Http\Request;

class RubrikController extends Controller
{
    public function index()
    {
        $rubriks = Rubrik::orderBy('penyelenggara')->orderBy('tingkat')->orderBy('peringkat')->orderBy('jenis')->get();

        return view('panel.rubrik-index', compact('rubriks'));
    }

    public function create()
    {
        $rubrik = null;

        return view('panel.rubrik-form', compact('rubrik'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'penyelenggara' => 'required|in:pemerintah,swasta',
            'peringkat' => 'required|in:juara1,juara2,juara3',
            'jenis' => 'required|in:perorangan,beregu',
            'tingkat' => 'required|in:nasional,provinsi,kabupaten',
            'kode' => 'required|string|max:10',
            'skor' => 'required|numeric|min:40|max:100',
        ]);

        Rubrik::updateOrCreate(
            [
                'penyelenggara' => $data['penyelenggara'],
                'peringkat' => $data['peringkat'],
                'jenis' => $data['jenis'],
                'tingkat' => $data['tingkat'],
            ],
            ['kode' => $data['kode'], 'skor' => $data['skor']]
        );

        return redirect()->route('panel.rubrik.index')->with('success', 'Rubrik berhasil disimpan.');
    }

    public function edit(Rubrik $rubrik)
    {
        return view('panel.rubrik-form', compact('rubrik'));
    }

    public function update(Request $request, Rubrik $rubrik)
    {
        $data = $request->validate([
            'penyelenggara' => 'required|in:pemerintah,swasta',
            'peringkat' => 'required|in:juara1,juara2,juara3',
            'jenis' => 'required|in:perorangan,beregu',
            'tingkat' => 'required|in:nasional,provinsi,kabupaten',
            'kode' => 'required|string|max:10',
            'skor' => 'required|numeric|min:40|max:100',
        ]);

        $rubrik->update($data);

        return redirect()->route('panel.rubrik.index')->with('success', 'Rubrik berhasil diperbarui.');
    }

    public function destroy(Rubrik $rubrik)
    {
        $rubrik->delete();

        return redirect()->route('panel.rubrik.index')->with('success', 'Rubrik berhasil dihapus.');
    }
}
