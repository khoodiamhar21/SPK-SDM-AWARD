<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'photo_path', 'nisn'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function isPanitia(): bool
    {
        return $this->role === 'panitia';
    }

    public function isWaka(): bool
    {
        return $this->role === 'wakasiswa';
    }

    public function isValidator(): bool
    {
        return $this->role === 'validator';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function avatarUrl(): string
    {
        return $this->photo_path
            ? asset('storage/'.$this->photo_path)
            : asset('img/default-avatar.png');
    }
}
