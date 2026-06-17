<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** Apakah user adalah admin penuh? */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Apakah user adalah petugas pendaftaran? */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /** Apakah user bisa akses panel admin? */
    public function canAccessAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
