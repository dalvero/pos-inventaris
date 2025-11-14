<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko', 'alamat', 'telepon', 'user_id'
    ];

    // RELASI KE ADMIN TOKO
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELASI KE KASIR
    public function kasirs()
    {
        return $this->hasMany(User::class)->where('role', 'kasir');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function bahanBakus()
    {
        return $this->hasMany(BahanBaku::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}
