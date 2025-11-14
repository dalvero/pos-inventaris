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
    
    public function toko()
    {
        // RELASI KE TABEL TOKO -> ONE TO MANY LEWAT toko_id
        return $this->belongsTo(Toko::class);
    }
    
    public function transaksis()
    {
        // RELASI KE TABEL TRANSAKSI -> ONE TO MANY LEWAT user_id (kasir_id)
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }
    
    public function shifts()
    {
        // RELASI KE TABEL SHIFT -> ONE TO MANY LEWAT user_id (kasir_id)
        return $this->hasMany(Shift::class, 'kasir_id');
    }
}
