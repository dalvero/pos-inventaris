<?php
namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function opening()
    {
        $user = Auth::user();

        // CEK APAKAH KASIR MASIH MEMILIKI SHIFT YANG BELUM CLOSING
        $shiftAktif = Shift::where('kasir_id', $user->id)
            ->whereNull('closing')
            ->first();

        if ($shiftAktif) {
            return redirect()->route('pos.menupesanan')
                ->with('info', 'Anda masih memiliki shift yang aktif.');
        }

        // BUAT SHIFT BARU
        Shift::create([
            'kasir_id' => $user->id,
            'toko_id' => $user->toko_id,
            'opening' => now(),
            'total_penjualan' => 0,
        ]);

        return redirect()->route('pos.menupesanan')
            ->with('success', 'Shift berhasil dibuka!');
    }

    public function closing()
    {
        $kasirId = Auth::id();
        $tokoId = Auth::user()->toko_id;

        // CARI SHIFT AKTIF
        $shift = Shift::where('kasir_id', $kasirId)
            ->where('toko_id', $tokoId)
            ->whereNull('closing')
            ->first();

        // JIKA TIDAK ADA SHIFT AKTIF
        if (!$shift) {
            return redirect()->route('dashboard')
                ->with('warning', 'Tidak ada shift yang aktif.');
        }

        // HITUNG TOTAL PENJUALAN SHIFT MENGGUNAKAN RANGE WAKTU
        $totalPenjualan = \App\Models\Transaksi::where('kasir_id', $kasirId)
            ->where('toko_id', $tokoId)
            ->whereBetween('waktu_transaksi', [$shift->opening, now()])
            ->sum('total_harga');

        // UPDATE SHIFT MENJADI CLOSED
        $shift->update([
            'closing' => now(),
            'total_penjualan' => $totalPenjualan
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Shift berhasil ditutup!');
    }


}
