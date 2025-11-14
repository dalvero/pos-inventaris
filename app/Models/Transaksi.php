<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id', 'kasir_id', 'total_harga', 'waktu_transaksi'
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
