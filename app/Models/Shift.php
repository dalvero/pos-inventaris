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
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
