<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\KategoriLomba;
use App\Models\Rubrik;
use App\Models\Tingkat;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class RubrikController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $rubriks = Rubrik::with('kategoriLomba')
            ->orderBy('tingkat')->orderBy('peringkat')->orderBy('jenis')->get();

        return view('panel.rubrik-index', compact('rubriks'));
    }

    public function create()
    {
        $rubrik = null;
        $tingkats = Tingkat::orderBy('urutan')->get();
        $kategoris = KategoriLomba::orderBy('nama')->get();

        return view('panel.rubrik-form', compact('rubrik', 'tingkats', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Rubrik::updateOrCreate(
            [
                'kategori_lomba_id' => $data['kategori_lomba_id'],
                'peringkat' => $data['peringkat'],
                'jenis' => $data['jenis'],
                'tingkat' => $data['tingkat'],
            ],
            ['kode' => $data['kode'], 'skor' => $data['skor']]
        );

        $this->log('create_rubrik', "Tambah rubrik {$data['kode']} ({$data['tingkat']} / {$data['peringkat']})");

        return redirect()->route('panel.rubrik.index')->with('success', 'Rubrik berhasil disimpan.');
    }

    public function edit(Rubrik $rubrik)
    {
        $tingkats = Tingkat::orderBy('urutan')->get();
        $kategoris = KategoriLomba::orderBy('nama')->get();

        return view('panel.rubrik-form', compact('rubrik', 'tingkats', 'kategoris'));
    }

    public function update(Request $request, Rubrik $rubrik)
    {
        $data = $this->validated($request);

        $rubrik->update($data);

        $this->log('update_rubrik', "Update rubrik {$rubrik->kode} ({$rubrik->tingkat} / {$rubrik->peringkat})");

        return redirect()->route('panel.rubrik.index')->with('success', 'Rubrik berhasil diperbarui.');
    }

    public function destroy(Rubrik $rubrik)
    {
        $rubrik->delete();

        return redirect()->route('panel.rubrik.index')->with('success', 'Rubrik berhasil dihapus.');
    }

    public function kategoriStore(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_lombas,nama',
        ]);

        KategoriLomba::create($data);

        return back()->with('success', 'Kategori lomba ditambahkan.');
    }

    public function kategoriDestroy(KategoriLomba $kategori)
    {
        $kategori->delete();

        return back()->with('success', 'Kategori lomba dihapus.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'kategori_lomba_id' => 'nullable|exists:kategori_lombas,id',
            'kategori_baru' => 'nullable|string|max:100',
            'peringkat' => 'required|in:juara1,juara2,juara3',
            'jenis' => 'required|in:perorangan,beregu',
            'tingkat' => 'required|string|exists:tingkats,kode',
            'kode' => 'required|string|max:10',
            'skor' => 'required|numeric|min:40|max:100',
        ]);

        if (empty($data['kategori_lomba_id']) && ! empty($data['kategori_baru'])) {
            $data['kategori_lomba_id'] = KategoriLomba::cariAtauBuat($data['kategori_baru'])->id;
        }

        abort_unless(! empty($data['kategori_lomba_id']), 422, 'Pilih atau isi kategori lomba.');

        return $data;
    }
}