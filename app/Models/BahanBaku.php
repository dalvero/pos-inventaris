<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id', 'nama_bahan', 'stok', 'satuan', 'minimum_stok'
    ];

    public function toko()
    {
        // RELASI KE TABEL TOKO -> ONE TO MANY LEWAT toko_id
        return $this->belongsTo(Toko::class); 
    }

    public function resepProduks()
    {
        // RELASI KE TABEL RESEP PRODUK -> MANY TO ONE LEWAT bahan_id
        return $this->hasMany(ResepProduk::class, 'bahan_id'); 
    }
}
