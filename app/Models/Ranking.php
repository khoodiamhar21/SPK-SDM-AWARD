<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ranking extends Model
{
    protected $fillable = [
        'periode_id', 'panitia_id', 'hasil', 'disetujui_kelas',
        'disetujui_oleh', 'disetujui_at', 'diumumkan_at',
    ];

    protected $casts = [
        'hasil' => 'array',
        'disetujui_kelas' => 'array',
        'disetujui_at' => 'datetime',
        'diumumkan_at' => 'datetime',
    ];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function panitia(): BelongsTo
    {
        return $this->belongsTo(User::class, 'panitia_id');
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
