<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'urutan'])]
class Kelas extends Model
{
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function next(): ?self
    {
        return self::where('urutan', $this->urutan + 1)->first();
    }
}
