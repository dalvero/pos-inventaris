<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // MENAMPILKAN DASHBOARD PRODUK
    public function dashboard(){
        return view('produk.dashboard');
    }

    // LIST PRODUK
    public function listProduk(){
        $produks = Auth::user()->toko->produks;

        return view('produk.produk', compact('produks'));
    }

    // FORM TAMBAH PRODUK
    public function create()
    {
        return view('produk.create');
    }

    // CARI PRODUK
    public function search(Request $request){
        $query = $request->input('query');

        $produks = Produk::where('toko_id', Auth::user()->toko->id)
            ->where('nama_produk', 'LIKE', "%{$query}%")
            ->get();

        return view('produk.produk', [
            'produks' => $produks,
            'search' => $query
        ]);
    }


    // SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPLOAD FOTO JIKA ADA
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('produk', 'public');
        }

        Produk::create([
            'toko_id' => Auth::user()->toko->id,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'foto' => $foto
        ]);

        return redirect()->route('produk.produk')->with('successTambahProduk', 'Produk berhasil ditambahkan!');
    }

    // FORM EDIT PRODUK
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        // PASTIKAN PRODUK MILIK TOKO ADMIN
        if ($produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        return view('produk.edit', compact('produk'));
    }

    // UPDATE PRODUK
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // JIKA UPLOAD FOTO BARU
        if ($request->hasFile('foto')) {
            // HAPUS FOTO LAMA
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            // UPLOAD FOTO BARU
            $produk->foto = $request->file('foto')->store('produk', 'public');
        }

        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // HAPUS PRODUK
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        // HAPUS FOTO JIKA ADA
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.produk')->with('successHapusProduk', 'Produk berhasil dihapus!');
    }
}
