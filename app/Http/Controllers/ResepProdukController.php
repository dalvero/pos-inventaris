<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ResepProduk;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResepProdukController extends Controller
{

    // MENAMPILKAN LIST RESEP
    public function listResep(){
        $tokosId = auth()->user()->toko_id;

        // LOAD RESEP DENGAN RELASI BAHAN
        $reseps = ResepProduk::whereHas('produk', function ($q) use ($tokosId) {
            $q->where('toko_id', $tokosId);
        })->with('bahan')->get(); 
        
        $bahans = BahanBaku::where('toko_id', $tokosId)->get();
        $produks = Produk::where('toko_id', $tokosId)
            ->whereHas('resepProduks')
            ->with(['resepProduks.bahan'])
            ->get();

        $semuaProduk = Produk::where('toko_id', $tokosId)->get();

        return view('resep.resep', compact('reseps', 'bahans', 'produks', 'semuaProduk'));
    }

    // MENCARI RESEP BERDASARKAN NAMA PRODUK
    public function search(Request $request)
    {
        $toko_id = Auth::user()->toko->id;
        $keyword = $request->input('keyword');
        $reseps = ResepProduk::whereHas('produk', function ($query) use ($toko_id, $keyword) {
            $query->where('toko_id', $toko_id)
                  ->where('nama', 'like', '%' . $keyword . '%');
        })->get();
        return view('produk.resep', compact('reseps', 'keyword'));
    }

    // SIMPAN RESEP BARU
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'bahan_id'  => 'required|array',
            'bahan_id.*'=> 'exists:bahan_bakus,id',
            'jumlah'    => 'required|array',
            'jumlah.*'  => 'numeric|min:0',
        ]);

        $produk_id = $request->produk_id;

        $produk = Produk::findOrFail($produk_id);

        if ($produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        // HAPUS RESEP LAMA JIKA ADA (BIAR tidak dobel)
        ResepProduk::where('produk_id', $produk_id)->delete();

        // INSERT BANYAK BAHAN SEKALIGUS
        $bahanIds = $request->bahan_id;
        $jumlahs  = $request->jumlah;

        foreach ($bahanIds as $index => $bahanId) {
            ResepProduk::create([
                'produk_id' => $produk_id,
                'bahan_id'  => $bahanId,
                'jumlah'    => $jumlahs[$index] ?? 0,
                'foto'      => $produk->foto,
            ]);
        }

        return redirect()->route('resep.resep')
            ->with('successTambahResep', 'Resep berhasil disimpan!');
    }


    // FORM EDIT RESEP
    public function edit($id)
    {
        $resep = ResepProduk::findOrFail($id);

        // PASTIKAN RESEP MILIK TOKO USER LEWAT RELASI PRODUK -> TOKO
        if ($resep->produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        $bahans = BahanBaku::where('toko_id', Auth::user()->toko->id)->get();

        return view('resep.edit', compact('resep', 'bahans'));
    }
    
    // UPDATE RESEP (berdasarkan produk_id)
    public function update(Request $request, $produk_id)
    {
        $produk = Produk::findOrFail($produk_id);

        // MEMASTIKAN PRODUK MILIK TOKO USER
        if ($produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        // VALIDASI
        $request->validate([
            'bahan_id'  => 'required|array',
            'bahan_id.*'=> 'exists:bahan_bakus,id',
            'jumlah'    => 'required|array',
            'jumlah.*'  => 'numeric|min:0',
        ]);

        // HAPUS RESEP LAMA
        ResepProduk::where('produk_id', $produk_id)->delete();

        // INSERT RESEP BARU
        $bahanIds = $request->bahan_id;
        $jumlahs  = $request->jumlah;

        foreach ($bahanIds as $index => $bahanId) {
            ResepProduk::create([
                'produk_id' => $produk_id,
                'bahan_id'  => $bahanId,
                'jumlah'    => $jumlahs[$index] ?? 0,
                'foto'      => $produk->foto,
            ]);
        }

        return redirect()->route('resep.resep')
            ->with('successEditResep', 'Resep berhasil diperbarui!');
    }


    // HAPUS RESEP
    public function destroy($id)
    {
        $resep = ResepProduk::findOrFail($id);

        if ($resep->produk->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        $produk_id = $resep->produk_id;

        $resep->delete();

        return redirect()->route('resep.resep', $produk_id)
            ->with('successHapusResep', 'Resep berhasil dihapus!');
    }
}
