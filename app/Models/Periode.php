<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $fillable = ['nama', 'tahun', 'tgl_buka', 'tgl_tutup', 'aktif'];

    protected $casts = [
        'tgl_buka' => 'date',
        'tgl_tutup' => 'date',
        'aktif' => 'boolean',
    ];

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class);
    }

    public function bobots(): HasMany
    {
        return $this->hasMany(Bobot::class);
    }
}
