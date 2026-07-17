<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestasi extends Model
{
    protected $fillable = [
        'siswa_id', 'periode_id', 'nama_kegiatan', 'tingkat',
        'peringkat', 'penyelenggara', 'jenis', 'nilai_rubrik',
        'tanggal', 'sertifikat_path', 'status_validasi', 'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai_rubrik' => 'decimal:2',
    ];

    public function isiNilaiRubrik(): void
    {
        $skor = Rubrik::cariSkor($this->penyelenggara, $this->peringkat, $this->jenis, $this->tingkat);
        $this->nilai_rubrik = $skor;
        $this->save();
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
}
