<?php

namespace App\Models;

// Catatan: ini adalah App\Models\User bawaan Laravel/Breeze,
// cukup TAMBAHKAN bagian yang ditandai di bawah ke file aslimu
// (jangan timpa seluruh file, karena Breeze sudah mengisi trait Authenticatable dkk).

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- tambahkan
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

    // ---------- Tambahan untuk Tugas 11 ----------

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }
}
