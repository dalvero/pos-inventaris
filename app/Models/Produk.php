<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id', 'nama_produk', 'harga'
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function resepProduks()
    {
        return $this->hasMany(ResepProduk::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
