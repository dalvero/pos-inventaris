<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    // FORM TAMBAH TOKO (ADMIN BARU)
    public function create()
    {
        return view('toko.create');
    }

    // DASHBOARD TOKO (MANAJEMEN TOKO)
    public function dashboard()
    {
        $tokoId = Auth::user()->toko_id;

        $kasirAktif = Shift::where('toko_id', $tokoId)
            ->whereNull('closing')
            ->with('kasir')
            ->get();

        return view('toko.dashboard', compact('kasirAktif'));
        
    }

    // HALAMAN KASIR (CARD KASIR)
    public function kasir()
    {
        return view('toko.kasir');
    }

    // MENAMPILKAN LIST KASIR
    public function listKasir(){
        $kasirs = Auth::user()->toko->kasirs;

        return view('toko.kasir', compact('kasirs'));
    }

    // SIMPAN TOKO BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat'    => 'required|string|max:500',
            'telepon'   => 'required|string|max:20',
            'qr_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPLOAD QR JIKA ADA
        $qrPath = null;
        if ($request->hasFile('qr_image')) {
            $qrPath = $request->file('qr_image')->store('qris', 'public');
        }

        $toko = Toko::create([
            'nama_toko' => $request->nama_toko,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'qr_image'  => $qrPath,
            'user_id'   => Auth::id(),
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Toko berhasil didaftarkan!');
    }

    // FORM EDIT TOKO
    public function edit($id)
    {
        $toko = Toko::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        return view('toko.edit', compact('toko'));
    }

    // UPDATE TOKO
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat'    => 'required|string|max:500',
            'telepon'   => 'required|string|max:20',
            'qr_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $toko = Toko::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        // JIKA UPLOAD QR BARU
        if ($request->hasFile('qr_image')) {

            // HAPUS QR LAMA JIKA ADA
            if ($toko->qr_image && Storage::disk('public')->exists($toko->qr_image)) {
                Storage::disk('public')->delete($toko->qr_image);
            }

            // UPLOAD QR BARU
            $qrPath = $request->file('qr_image')->store('qris', 'public');

            $toko->qr_image = $qrPath;
        }

        // UPDATE DATA TOKO LAINNYA
        $toko->nama_toko = $request->nama_toko;
        $toko->alamat    = $request->alamat;
        $toko->telepon   = $request->telepon;

        $toko->save();

        return redirect()->route('toko.dashboard')
            ->with('success', 'Data toko berhasil diperbarui!');
    }
}
