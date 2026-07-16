<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $fillable = ['kode', 'nama', 'keterangan'];

    public function bobots(): HasMany
    {
        return $this->hasMany(Bobot::class);
    }
}
