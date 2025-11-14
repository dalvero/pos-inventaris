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
        return $this->belongsTo(Produk::class);
    }

    public function bahan()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }
}
