<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',  // ← AJOUTÉ
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========== MÉTHODES DE RÔLE ==========

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isJuge(): bool
    {
        return $this->role === 'juge';
    }

    public function isGreffier(): bool
    {
        return $this->role === 'greffier';
    }

    public function isMagasinier(): bool
    {
        return $this->role === 'magasinier';
    }
}