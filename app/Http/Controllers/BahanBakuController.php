<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BahanBakuController extends Controller
{
    // DASHBOARD BAHAN BAKU
    public function dashboard()
    {
        return view('bahanbaku.dashboard');
    }

    // LIST BAHAN BAKU
    public function listBahan()
    {
        $bahans = BahanBaku::where('toko_id', Auth::user()->toko->id)
            ->orderBy('nama_bahan', 'asc')
            ->paginate(10); // ATUR BERAPA DATA PER HALAMAN

        return view('bahanbaku.bahanbaku', compact('bahans'));
    }

    // FORM TAMBAH BAHAN BAKU
    public function create()
    {
        return view('bahanbaku.create');
    }

    // CARI BAHAN BAKU
    public function search(Request $request)
    {
        $query = $request->input('query');

        $bahans = BahanBaku::where('toko_id', Auth::user()->toko->id)
            ->where('nama_bahan', 'LIKE', "%{$query}%")
            ->orderBy('nama_bahan', 'asc')
            ->paginate(10)
            ->appends(['query' => $query]); // AGAR PAGE TIDAK RESET SAAR SEARCH


        return view('bahanbaku.bahanbaku', [
            'bahans' => $bahans,
            'search' => $query
        ]);
    }

    // SIMPAN BAHAN BAKU BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'minimum_stok' => 'required|numeric|min:0',
        ]);

        BahanBaku::create([
            'toko_id' => Auth::user()->toko->id,
            'nama_bahan' => $request->nama_bahan,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'minimum_stok' => $request->minimum_stok,
        ]);

        return redirect()->route('bahanbaku.bahanbaku')
            ->with('successTambahBahanBaku', 'Bahan baku berhasil ditambahkan!');
    }

    // FORM EDIT BAHAN BAKU
    public function edit($id)
    {
        $bahan = BahanBaku::findOrFail($id);

        if ($bahan->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        return view('bahanbaku.edit', compact('bahan'));
    }

    // UPDATE BAHAN BAKU
    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        if ($bahan->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'minimum_stok' => 'required|numeric|min:0',
        ]);

        $bahan->update([
            'nama_bahan' => $request->nama_bahan,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'minimum_stok' => $request->minimum_stok,
        ]);

        return redirect()->route('bahanbaku.bahanbaku')
            ->with('successEditBahan', 'Bahan baku berhasil diperbarui!');
    }

    // HAPUS BAHAN BAKU
    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);

        if ($bahan->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }

        $bahan->delete();

        return redirect()->route('bahanbaku.bahanbaku')
            ->with('successHapusBahanBaku', 'Bahan baku berhasil dihapus!');
    }
}

