<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id', 'produk_id', 'harga_satuan', 'jumlah', 'subtotal'
    ];

    public function transaksi()
    {
        // RELASI KE TABEL TRANSAKSI -> ONE TO MANY LEWAT transaksi_id
        return $this->belongsTo(Transaksi::class); 
    }

    public function produk()
    {
        // RELASI KE TABEL PRODUK -> ONE TO MANY LEWAT produk_id
        return $this->belongsTo(Produk::class);
    }
}
