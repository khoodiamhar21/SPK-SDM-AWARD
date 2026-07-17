<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id', 'nisn', 'nama', 'kelas_id', 'foto', 'tempat_lahir',
    'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp_ortu',
    'waktu_registrasi_pertama', 'periode_terakhir_ikuti',
])]
#[Hidden([])]
class Siswa extends Model
{
    protected $casts = [
        'tanggal_lahir' => 'date',
        'waktu_registrasi_pertama' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function periodeTerakhir(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_terakhir_ikuti');
    }

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class);
    }

    public function naikKelas(): void
    {
        $next = $this->kelas?->next();
        if ($next) {
            $this->kelas_id = $next->id;
            $this->save();
        }
    }
}

