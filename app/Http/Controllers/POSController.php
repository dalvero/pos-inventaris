<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Models\ResepProduk;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use App\Models\DetailTransaksi; 
use App\Models\Toko;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function menupesanan()
    {
        // Pastikan user login & punya toko
        if (!Auth::check() || !Auth::user()->toko_id) {
            return redirect()->route('login')->with(
                'error',
                'Akses ditolak. Silakan login menggunakan akun toko.'
            );
        }

        $tokoId = Auth::user()->toko_id;

        // Ambil produk milik toko
        $produk = Produk::select('id', 'nama_produk', 'harga', 'foto')
            ->where('toko_id', $tokoId)
            ->orderBy('nama_produk', 'asc')
            ->get();

        // Kirim data ke view
        return view('pos.menupesanan', compact('produk'));
    }

    public function checkout(Request $request)
    {
        // 1. Validasi Dasar Request
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.produk_id' => 'required|exists:produks,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        $tokoId = Auth::user()->toko_id;
        $cartItems = $request->input('cart_items');
        $grandTotal = $request->input('total_amount');
        $customerName = $request->input('customer_name');

        // 2. Kumpulkan Total Kebutuhan Bahan Baku (Pengecekan Stok Gabungan)
        $totalBahanDibutuhkan = [];
        
        // Ambil ID produk yang ada di keranjang
        $produkIds = collect($cartItems)->pluck('produk_id')->unique();
        
        // Eager load semua resep yang dibutuhkan dari produk-produk di keranjang
        $produkDiKeranjang = Produk::whereIn('id', $produkIds)
            ->with(['resepProduks.bahan'])
            ->get()
            ->keyBy('id'); // Key by ID agar mudah dicari

        foreach ($cartItems as $item) {
            $produk = $produkDiKeranjang->get($item['produk_id']);
            $qty = $item['quantity'];

            // Jika produk tidak ditemukan atau tidak memiliki resep, lewati
            if (!$produk || $produk->resepProduks->isEmpty()) {
                continue; 
            }

            foreach ($produk->resepProduks as $resep) {
                $bahanId = $resep->bahan_id;
                $jumlahPerUnit = $resep->jumlah;
                $totalKebutuhanItem = $jumlahPerUnit * $qty;

                // Tambahkan total kebutuhan ke array gabungan
                // Ini menangani pembagian stok (Gula Cair) untuk berbagai menu.
                $totalBahanDibutuhkan[$bahanId] = ($totalBahanDibutuhkan[$bahanId] ?? 0) + $totalKebutuhanItem;
            }
        }
        
        // 3. Validasi Stok Akhir
        foreach ($totalBahanDibutuhkan as $bahanId => $kebutuhan) {
            $bahan = BahanBaku::find($bahanId); // Ambil data BahanBaku untuk stok aktual
            
            // Cek apakah stok bahan baku mencukupi
            if (!$bahan || $bahan->stok < $kebutuhan) {
                $bahanName = $bahan ? $bahan->nama_bahan : 'Bahan Tidak Dikenal';
                // jika request ajax / expects json
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok bahan baku '{$bahanName}' tidak mencukupi. Dibutuhkan: {$kebutuhan}, Tersedia: " . ($bahan->stok ?? 0)
                    ], 400);
                }
                return redirect()->back()->with('stok_habis', [
                    'judul' => 'Stok Tidak Cukup!',
                    'pesan' => "Stok bahan baku '{$bahanName}' tidak mencukupi..."
                ]);
            }
        }
        
        // 4. Proses Transaksi (Menggunakan Database Transaction untuk keamanan)
        try {
            DB::beginTransaction();

            // 4a. Buat Transaksi Header
            $transaksi = Transaksi::create([
                'toko_id' => $tokoId,
                'user_id' => Auth::id(),
                'nama_pelanggan' => $customerName,
                'total_harga' => $grandTotal,
                'waktu_transaksi' => Carbon::now(),
            ]);

            // 4b. Buat Detail Transaksi dan Kurangi Stok Bahan Baku
            foreach ($cartItems as $item) {
                // Buat Detail Transaksi
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga_satuan'],
                ]);

                // Kurangi Stok Bahan Baku
                $produk = $produkDiKeranjang->get($item['produk_id']);
                
                foreach ($produk->resepProduks as $resep) {
                    $bahan = $resep->bahan; // Relasi bahan sudah di-load dari BahanBaku
                    $jumlahPerUnit = $resep->jumlah;
                    $totalKebutuhanItem = $jumlahPerUnit * $item['quantity'];

                    // Lakukan pengurangan stok aktual
                    // NOTE: Pengurangan stok berdasarkan total kebutuhan yang dihitung di Langkah 2
                    $bahan->stok -= $totalKebutuhanItem; 
                    $bahan->save(); // Update stok di database
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses.',
                'transaksi_id' => $transaksi->id
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error untuk debugging di server
            \Log::error('Checkout Failed: ' . $e->getMessage()); 

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server saat memproses transaksi. Transaksi dibatalkan.'
            ], 500);
        }
    }

    public function showStruk($id)
    {
        $transaksi = Transaksi::with(['detailTransaksis.produk', 'kasir', 'toko'])
            ->findOrFail($id);
            
        // Pastikan transaksi milik toko user yang sedang login (keamanan)
        if ($transaksi->toko_id !== Auth::user()->toko_id) {
            abort(403, 'Akses ditolak.');
        }

        return view('pos.detailpesanan', compact('transaksi'));
    }

    public function resep()
    {
        $tokoId = Auth::user()->toko_id;

        // Ambil semua produk milik toko
        $semuaProduk = Produk::where('toko_id', $tokoId)->get();

        // Ambil resep + relasinya
        $reseps = ResepProduk::with(['bahan', 'produk'])
            ->whereHas('produk', function ($q) use ($tokoId) {
                $q->where('toko_id', $tokoId);
            })
            ->get();

        return view('pos.resep', [
            'reseps' => $reseps,
            'produks' => $semuaProduk
        ]);

    }

    // LIST BAHAN BAKU
    public function listBahan(Request $request)
    {
        $query = $request->input('query');
        $bahansQuery = BahanBaku::where('toko_id', Auth::user()->toko->id);
        
        if ($query) {
            $bahansQuery->where('nama_bahan', 'LIKE', '%' . $query . '%');
        }

        $bahans = $bahansQuery
            ->orderBy('nama_bahan', 'asc')
            ->paginate(10)
            ->appends(['query' => $query]);

        return view('pos.bahanbaku', compact('bahans', 'query'));
    }

    public function listTransaksi()
    {
        $today = Carbon::today();
        
        $transaksis = Transaksi::where('toko_id', Auth::user()->toko->id)
            ->whereDate('waktu_transaksi', $today) 
            ->with(['detailTransaksis', 'kasir']) 
            ->orderBy('waktu_transaksi', 'desc')
            ->get(); 

        $totalPenjualan = $transaksis->sum('total_harga'); 

        $transaksisPaginated = Transaksi::where('toko_id', Auth::user()->toko->id)
            ->whereDate('waktu_transaksi', $today) 
            ->with(['detailTransaksis', 'kasir'])
            ->orderBy('waktu_transaksi', 'desc')
            ->paginate(15);


        return view('pos.transaksi', [
            'transaksis' => $transaksisPaginated, 
            'totalPenjualan' => $totalPenjualan,
            'allTransaksis' => $transaksis->toJson()
        ]);
    }

}



   