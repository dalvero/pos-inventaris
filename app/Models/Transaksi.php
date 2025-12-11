<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [        
        'toko_id',
        'kasir_id',
        'nama_pelanggan',
        'kode_transaksi', 
        'total_harga',
        'metode_pembayaran',   // CASH | QRIS
        'uang_diterima',       // UNTUK CASH
        'kembalian',           // UNTUK CASH
        'status',              // PAID | UNPAID | FAILED
        'waktu_transaksi'
    ];

    protected $casts = [
        'waktu_transaksi' => 'datetime',
        'total_harga' => 'integer',
        'uang_diterima' => 'integer',
        'kembalian' => 'integer',
    ];

    // RELASI KE TOKO
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    // RELASI KE KASIR (USER)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    // RELASI KE DETAIL TRANSAKSI
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // ACCESSOR: STATUS BADGE
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'paid' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>',
            'unpaid' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Belum Bayar</span>',
            'failed' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>',
        ];

        return $badges[$this->status] ?? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">-</span>';
    }

    // ACCESSOR: METODE BADGE
    public function getMetodeBadgeAttribute()
    {
        $badges = [
            'cash' => '<span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">💵 Cash</span>',
            'qris' => '<span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-800">📱 QRIS</span>',
        ];

        return $badges[$this->metode_pembayaran] ?? '-';
    }
}