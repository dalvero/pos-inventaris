<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'toko_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // RELASI KE TOKO (OPTIONAL UNTUK KASIR/SUPER ADMIN)
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    // RELASI KE TRANSAKSI (JIKA ROLE KASIR)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }

    // RELASI KE SHIFT
    public function shifts()
    {
        return $this->hasMany(Shift::class, 'kasir_id');
    }
}
