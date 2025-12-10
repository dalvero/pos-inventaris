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

    public function isAvailable()
    {
        // 1. Ambil semua resep yang dibutuhkan untuk produk ini
        $resep = $this->resepProduks; 

        // Jika tidak ada resep, asumsikan produk tidak bisa dijual/dibuat
        if ($resep->isEmpty()) {
            return false; 
        }

        foreach ($resep as $itemResep) {
            // Kita mengakses BahanBaku melalui relasi 'bahan()' di ResepProduk
            $stok_saat_ini = $itemResep->bahan->stok ?? 0;
            // Jumlah yang dibutuhkan per 1 resep produk
            $jumlah_dibutuhkan = $itemResep->jumlah; 

            // Jika stok bahan baku kurang dari jumlah yang dibutuhkan resep, 
            // maka produk tidak tersedia.
            if ($stok_saat_ini < $jumlah_dibutuhkan) {
                return false; 
            }
        }

        // Jika semua bahan baku memiliki stok yang mencukupi, maka tersedia
        return true;
    }
}
