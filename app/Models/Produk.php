<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'nama_produk',
        'harga',
        'foto'
    ];

    public function toko()
    {
        // RELASI KE TABEL TOKO -> ONE TO MANY LEWAT toko_id
        return $this->belongsTo(Toko::class);
    }

    public function resepProduks()
    {
        // RELASI KE TABEL RESEP PRODUK -> MANY TO ONE LEWAT produk_id
        return $this->hasMany(ResepProduk::class);
    }

    public function detailTransaksis()
    {
        // RELASI KE TABEL DETAIL TRANSAKSI -> MANY TO ONE LEWAT produk_id
        return $this->hasMany(DetailTransaksi::class);
    }
}
