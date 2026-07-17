<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubrik extends Model
{
    protected $fillable = [
        'penyelenggara', 'peringkat', 'jenis', 'tingkat', 'kode', 'skor',
    ];

    protected $casts = [
        'skor' => 'decimal:2',
    ];

    public static function cariSkor(string $penyelenggara, string $peringkat, string $jenis, string $tingkat): ?float
    {
        $row = self::where('penyelenggara', $penyelenggara)
            ->where('peringkat', $peringkat)
            ->where('jenis', $jenis)
            ->where('tingkat', $tingkat)
            ->first();

        return $row ? (float) $row->skor : null;
    }
}
