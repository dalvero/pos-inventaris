<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'kasir_id', 'toko_id', 'opening', 'break', 'closing', 'total_penjualan'
    ];

    public function kasir()
    {
        // RELASI KE TABEL USER (ROLE KASIR) -> ONE TO MANY LEWAT user_id (kasir_id)
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function toko()
    {
        // RELASI KE TABEL TOKO -> ONE TO MANY LEWAT toko_id
        return $this->belongsTo(Toko::class);
    }
}
