<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Rubrik;
use App\Models\Siswa;
use App\Services\SawService;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    use LogsActivity;

    private function isValidator(): bool
    {
        return auth()->user()->isValidator();
    }

    // VALIDASI BERJENJANG: Kelas -> Siswa -> Prestasi
    public function kelas()
    {
        $kelas = Kelas::orderBy('urutan')->get();
        $periode = Periode::where('aktif', true)->first();

        $rekap = collect();
        if ($periode) {
            $rekap = Prestasi::with(['siswa.kelas', 'periode'])
                ->where('periode_id', $periode->id)
                ->when($this->isValidator(), fn ($q) => $q->where('status_validasi', 'menunggu'))
                ->orderBy('status_validasi')
                ->get()
                ->sortBy(fn ($p) => ($p->siswa?->kelas?->urutan ?? 99).'|'.$p->siswa?->nama)
                ->values();
        }

        return view('panel.validasi-kelas', compact('kelas', 'periode', 'rekap'));
    }

    public function siswa(Kelas $kelas)
    {
        $periode = Periode::where('aktif', true)->first();
        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->whereHas('prestasis', function ($q) use ($periode) {
                $q->where('periode_id', $periode?->id);
                if ($this->isValidator()) {
                    $q->where('status_validasi', 'menunggu');
                }
            })
            ->withCount(['prestasis' => function ($q) use ($periode) {
                $q->where('periode_id', $periode?->id);
                if ($this->isValidator()) {
                    $q->where('status_validasi', 'menunggu');
                }
            }])
            ->orderBy('nama')->get();

        return view('panel.validasi-siswa', compact('kelas', 'siswas', 'periode'));
    }

    public function prestasi(Siswa $siswa)
    {
        $periode = Periode::where('aktif', true)->first();
        $query = $siswa->prestasis()->where('periode_id', $periode?->id);
        if ($this->isValidator()) {
            $query->where('status_validasi', 'menunggu');
        }
        $prestasis = $query->latest()->get();

        return view('panel.validasi-prestasi', compact('siswa', 'prestasis', 'periode'));
    }

    public function index(Request $request)
    {
        $periode = Periode::where('aktif', true)->first();
        $status = $this->isValidator() ? 'menunggu' : $request->get('status', 'menunggu');

        $query = Prestasi::with(['siswa', 'periode'])
            ->when($periode, fn ($q) => $q->where('periode_id', $periode->id))
            ->where('status_validasi', $status)
            ->latest();

        $prestasis = $query->paginate(12)->withQueryString();
        $counts = [
            'menunggu' => Prestasi::where('status_validasi', 'menunggu')->when($periode, fn ($q) => $q->where('periode_id', $periode->id))->count(),
            'valid' => Prestasi::where('status_validasi', 'valid')->when($periode, fn ($q) => $q->where('periode_id', $periode->id))->count(),
            'ditolak' => Prestasi::where('status_validasi', 'ditolak')->when($periode, fn ($q) => $q->where('periode_id', $periode->id))->count(),
        ];

        return view('panel.validasi-index', compact('prestasis', 'status', 'counts', 'periode'));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa', 'periode']);

        return view('panel.validasi-show', compact('prestasi'));
    }

    public function putusan(Request $request, Prestasi $prestasi)
    {
        $data = $request->validate([
            'status_validasi' => 'required|in:valid,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $update = [
            'status_validasi' => $data['status_validasi'],
            'catatan' => $data['catatan'] ?? $prestasi->catatan,
        ];

        // Auto-assign nilai dari rubrik saat validasi
        if ($data['status_validasi'] === 'valid') {
            $skor = Rubrik::cariSkor(
                $prestasi->kategori_lomba_id,
                $prestasi->peringkat,
                $prestasi->jenis,
                $prestasi->tingkat
            );
            $update['nilai_rubrik'] = $skor;
        } else {
            $update['nilai_rubrik'] = null;
        }

        $prestasi->update($update);

        $this->log('validasi_prestasi',
            "Putusan {$data['status_validasi']} prestasi #{$prestasi->id} {$prestasi->nama_kegiatan} - {$prestasi->siswa->nama}",
            $prestasi
        );
        SawService::flushCache($prestasi->periode_id);

        return redirect()->route('panel.validasi.prestasi', $prestasi->siswa)
            ->with('status', 'Putusan berkas: '.($data['status_validasi'] === 'valid' ? 'LOLOS validasi' : 'DITOLAK').'.');
    }
}
