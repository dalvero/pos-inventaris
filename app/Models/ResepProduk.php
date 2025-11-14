<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResepProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id', 'bahan_id', 'jumlah'
    ];

    public function produk()
    {
        // RELASI KE TABEL PRODUK -> ONE TO MANY LEWAT produk_id
        return $this->belongsTo(Produk::class);
    }

    public function bahan()
    {
        // RELASI KE TABEL BAHAN BAKU -> ONE TO MANY LEWAT bahan_id
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}
