<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    // FORM TAMBAH TOKO (ADMIN BARU)
    public function create()
    {
        return view('toko.create');
    }

    // SIMPAN TOKO BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'telepon' => 'required|string|max:20',
        ]);

        // Membuat toko baru untuk admin
        $toko = Toko::create([
            'nama_toko' => $request->nama_toko,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
            'user_id'   => Auth::id()
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Toko berhasil didaftarkan!');
    }

    // FORM EDIT TOKO
    public function edit($id)
    {
        $toko = Toko::where('id', $id)
                    ->where('user_id', Auth::id()) // aman: milik user
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
        ]);

        $toko = Toko::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $toko->update([
            'nama_toko' => $request->nama_toko,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Data toko berhasil diperbarui!');
    }
}
