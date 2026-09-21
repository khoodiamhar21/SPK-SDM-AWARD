<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rubrik extends Model
{
    protected $fillable = [
        'kategori_lomba_id', 'peringkat', 'jenis', 'tingkat', 'kode', 'skor',
    ];

    protected $casts = [
        'skor' => 'decimal:2',
    ];

    public function kategoriLomba(): BelongsTo
    {
        return $this->belongsTo(KategoriLomba::class);
    }

    public static function cariSkor(int|string|null $kategoriLombaId, string $peringkat, string $jenis, string $tingkat): ?float
    {
        $row = self::where('kategori_lomba_id', $kategoriLombaId)
            ->where('peringkat', $peringkat)
            ->where('jenis', $jenis)
            ->where('tingkat', $tingkat)
            ->first();

        return $row ? (float) $row->skor : null;
    }
}
