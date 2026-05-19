<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // ← tambahkan role di sini
    ];

    // Kolom yang disembunyikan saat data dikonversi ke JSON/array
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

    // ─────────────────────────────────────────
    // Helper method: cek apakah user adalah admin
    // Contoh pemakaian di blade: @if(Auth::user()->isAdmin())
    // Contoh pemakaian di controller: if ($user->isAdmin())
    // ─────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relasi: satu user punya banyak koleksi
    public function koleksis()
    {
        return $this->hasMany(Koleksi::class);
    }
}