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
        // RELASI KE TABEL TOKO -> ONE TO MANY LEWAT toko_id
        return $this->belongsTo(Toko::class);
    }

    public function kasir()
    {
        // RELASI KE TABEL USER (ROLE KASIR) -> ONE TO MANY LEWAT user_id (kasir_id)
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function detailTransaksis()
    {
        // RELASI KE TABEL DETAIL TRANSAKSI -> MANY TO ONE LEWAT transaksi_id
        return $this->hasMany(DetailTransaksi::class);
    }
}
