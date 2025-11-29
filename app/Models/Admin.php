<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Gunakan tabel 'users'
    protected $table = 'users';

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Sembunyikan kolom sensitif
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Scope untuk filter admin.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Mengecek apakah user ini admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
