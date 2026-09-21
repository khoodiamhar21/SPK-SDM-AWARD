<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tingkat extends Model
{
    protected $fillable = ['kode', 'nama', 'kriteria_id', 'urutan'];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
