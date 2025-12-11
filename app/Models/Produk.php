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
        return $this->hasMany(ResepProduk::class, 'produk_id');
    }

    public function detailTransaksis()
    {
        // RELASI KE TABEL DETAIL TRANSAKSI -> MANY TO ONE LEWAT produk_id
        return $this->hasMany(DetailTransaksi::class);
    }

    public function isAvailable()
    {
        // AMBIL SEMUA RESEP YANG DIBUTUHKAN UNTUK PRODUK INI
        $resep = $this->resepProduks; 

        // JIKA TIDAK ADA RESEP, ASUMSIKAN PRODUK TIDAK BISA DIJUAL/DIBUAT        
        if ($resep->isEmpty()) {
            return false; 
        }

        foreach ($resep as $itemResep) {            
            $stok_saat_ini = $itemResep->bahan->stok ?? 0;
            // JUMLAH YANG DIBUTUHKAN PER 1 RESEP PRODUK
            $jumlah_dibutuhkan = $itemResep->jumlah; 

            // JIKA STOK BAHAN BAKU KURANG DARI JUMLAH YANG DIBUTUHKAN RESEP
            // MAKA PRODUK TIDAK TERSEDIA
            if ($stok_saat_ini < $jumlah_dibutuhkan) {
                return false; 
            }
        }

        // JIKA SEMUA BAHAN BAKU MEMILIKIS STOK YANG MENCUKUPI, MAKA TERSEDIA        
        return true;
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
