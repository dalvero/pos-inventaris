<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko', 'alamat', 'qr_image', 'telepon', 'user_id'
    ];
    
    public function admin()
    {
        // RELASI KE TABEL USER (ROLE ADMIN TOKO) -> ONE TO MANY LEWAT user_id
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function kasirs()
    {
        // RELASI KE TABEL USER (ROLE KASIR) -> ONE TO MANY LEWAT user_id
        return $this->hasMany(User::class)->where('role', 'kasir');
    }

    public function produks()
    {
        // RELASI KE TABEL PRODUK -> ONE TO MANY LEWAT toko_id
        return $this->hasMany(Produk::class);
    }

    public function bahanBakus()
    {
        // RELASI KE TABEL BAHAN BAKU -> ONE TO MANY LEWAT toko_id
        return $this->hasMany(BahanBaku::class);
    }

    public function transaksis()
    {
        // RELASI KE TABEL TRANSAKSI -> ONE TO MANY LEWAT toko_id
        return $this->hasMany(Transaksi::class);
    }

    public function shifts()
    {
        // RELASI KE TABEL SHIFT -> ONE TO MANY LEWAT toko_id
        return $this->hasMany(Shift::class);
    }
}
