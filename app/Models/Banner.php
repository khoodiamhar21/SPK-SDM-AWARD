<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banner extends Model
{
    protected $fillable = ['foto_path', 'judul', 'urutan', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];
}
