<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriLomba extends Model
{
    protected $fillable = ['nama', 'jenis_prestasi'];

    public function rubriks(): HasMany
    {
        return $this->hasMany(Rubrik::class);
    }

    public static function cariAtauBuat(string $nama): self
    {
        return self::firstOrCreate(['nama' => trim($nama)]);
    }
}