<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @mixin \Illuminate\Database\Eloquent\Builder */
class Kelas extends Model
{
    protected $fillable = ['nama', 'urutan'];
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function next(): ?self
    {
        return self::where('urutan', $this->urutan + 1)->first();
    }
}
