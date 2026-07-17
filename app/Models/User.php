<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

    #[Fillable(['name', 'email', 'password', 'role', 'photo_path', 'nisn'])]
    #[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
