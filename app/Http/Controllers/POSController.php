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
        // PASTIKAN USER LOGIN & PUNYA TOKO
        if (!Auth::check() || !Auth::user()->toko_id) {
            return redirect()->route('login')->with(
                'error',
                'Akses ditolak. Silakan login menggunakan akun toko.'
            );
        }

        $tokoId = Auth::user()->toko_id;

        // AMBIL PRODUK MILIK TOKO
        $produk = Produk::select('id', 'nama_produk', 'harga', 'foto')
            ->where('toko_id', $tokoId)
            ->orderBy('nama_produk', 'asc')
            ->get();
        
        return view('pos.menupesanan', compact('produk'));
    }

    public function checkout(Request $request)
    {
        try {
            // VALIDASI INPUT
            $request->validate([
                'total_amount' => 'required|numeric|min:0',
                'customer_name' => 'required|string|max:255',
                'cart_items' => 'required|array|min:1',
                'cart_items.*.produk_id' => 'required|exists:produks,id',
                'cart_items.*.quantity' => 'required|integer|min:1',
                'cart_items.*.harga_satuan' => 'required|numeric|min:0',
            ]);

            $tokoId = Auth::user()->toko_id;
            
            // VALIDASI USER MEMILIKI TOKO
            if (!$tokoId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak memiliki toko yang terdaftar'
                ], 403);
            }

            $cartItems = $request->input('cart_items');
            $grandTotal = $request->input('total_amount');
            $customerName = $request->input('customer_name', 'Umum');

            // KUMPULKAN TOTAL KEBUTUHAN BAHAN BAKU
            $totalBahanDibutuhkan = [];
            
            $produkIds = collect($cartItems)->pluck('produk_id')->unique();
            
            // LOAD PRODUK DENGAN RELASI LENGKAP
            $produkDiKeranjang = Produk::whereIn('id', $produkIds)
                ->where('toko_id', $tokoId) // PASTIKAN PRODUK MILIK TOKO YANG SAMA
                ->with(['resepProduks' => function($query) {
                    $query->with('bahan');
                }])
                ->get()
                ->keyBy('id');

            // VALIDASI SEMUA PRODUK DITEMUKAN
            foreach ($cartItems as $item) {
                if (!$produkDiKeranjang->has($item['produk_id'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Produk dengan ID ' . $item['produk_id'] . ' tidak ditemukan atau bukan milik toko Anda'
                    ], 404);
                }
            }

            // HITUNG TOTAL KEBUTUHAN BAHAN
            foreach ($cartItems as $item) {
                $produk = $produkDiKeranjang->get($item['produk_id']);
                $qty = $item['quantity'];

                // SKIP JIKA PRODUK TIDAK PUNYA RESEP
                if (!$produk || !$produk->resepProduks || $produk->resepProduks->isEmpty()) {
                    \Log::warning("Produk ID {$item['produk_id']} tidak memiliki resep");
                    continue; 
                }

                foreach ($produk->resepProduks as $resep) {
                    // VALIDASI BAHAN ADA
                    if (!$resep->bahan) {
                        \Log::error("Resep ID {$resep->id} tidak memiliki bahan yang terkait");
                        return response()->json([
                            'success' => false,
                            'message' => 'Data resep tidak lengkap untuk produk: ' . $produk->nama_produk
                        ], 400);
                    }

                    $bahanId = $resep->bahan_id;
                    $jumlahPerUnit = $resep->jumlah;
                    $totalKebutuhanItem = $jumlahPerUnit * $qty;

                    $totalBahanDibutuhkan[$bahanId] = ($totalBahanDibutuhkan[$bahanId] ?? 0) + $totalKebutuhanItem;
                }
            }
            
            // VALIDASI STOK
            foreach ($totalBahanDibutuhkan as $bahanId => $kebutuhan) {
                $bahan = BahanBaku::where('id', $bahanId)
                    ->where('toko_id', $tokoId)
                    ->first();
                
                if (!$bahan) {
                    return response()->json([
                        'success' => false,
                        'message' => "Bahan baku dengan ID {$bahanId} tidak ditemukan"
                    ], 404);
                }

                if ($bahan->stok < $kebutuhan) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok bahan baku '{$bahan->nama_bahan}' tidak mencukupi. Dibutuhkan: {$kebutuhan}, Tersedia: {$bahan->stok}"
                    ], 400);
                }
            }
            
            // PROSES TRANSAKSI
            DB::beginTransaction();

            try {
                // BUAT TRANSAKSI (STATUS UNPAID)
                $transaksi = Transaksi::create([
                    'toko_id' => $tokoId,
                    'kasir_id' => Auth::id(),
                    'nama_pelanggan' => $customerName,
                    'kode_transaksi' => $this->generateKodeTransaksi($tokoId),
                    'total_harga' => $grandTotal,
                    'status' => 'unpaid',
                    'waktu_transaksi' => Carbon::now(),
                ]);

                // BUAT DETAIL TRANSAKSI DAN KURANGI STOK
                foreach ($cartItems as $item) {
                    // BUAT DETAIL TRANSAKSI
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $item['produk_id'],
                        'jumlah' => $item['quantity'],
                        'subtotal' => $item['harga_satuan'] * $item['quantity'],
                        'harga_satuan' => $item['harga_satuan'],
                    ]);

                    // KURANGI STOK BAHAN BAKU
                    $produk = $produkDiKeranjang->get($item['produk_id']);
                    
                    if ($produk && $produk->resepProduks) {
                        foreach ($produk->resepProduks as $resep) {
                            if ($resep->bahan) {
                                $bahan = $resep->bahan;
                                $jumlahPerUnit = $resep->jumlah;
                                $totalKebutuhanItem = $jumlahPerUnit * $item['quantity'];

                                // UPDATE STOK
                                $bahan->stok -= $totalKebutuhanItem;
                                $bahan->save();

                                \Log::info("Stok {$bahan->nama_bahan} dikurangi {$totalKebutuhanItem}, sisa: {$bahan->stok}");
                            }
                        }
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
                \Log::error('Checkout Transaction Failed: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());

                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Checkout Validation Failed: ' . json_encode($e->errors()));
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Checkout Failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    // TAMPILKAN HALAMAN PEMBAYARAN
    public function pembayaran($id)
    {
        $transaksi = Transaksi::with('detailTransaksis.produk')
            ->findOrFail($id);

        // KEAMANAN: PASTIKAN MILIK TOKO
        if ($transaksi->toko_id !== Auth::user()->toko_id) {
            abort(403, 'Akses ditolak.');
        }

        // JIKA SUDAH DIBAYAR, REDIRECT KE STRUK
        if ($transaksi->status === 'paid') {
            return redirect()->route('pos.strukpesanan', $id)
                ->with('info', 'Transaksi sudah dibayar.');
        }

        return view('pos.pembayaran', compact('transaksi'));
    }

    // PEMBAYARAN CASH
    public function bayarCash(Request $request, $id)
    {
        $request->validate([
            'uang_diterima' => 'required|numeric|min:0'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        // KEAMANAN
        if ($transaksi->toko_id !== Auth::user()->toko_id) {
            abort(403);
        }

        // CEK STATUS
        if ($transaksi->status === 'paid') {
            return back()->with('error', 'Transaksi sudah dibayar.');
        }

        $uangDiterima = (int) $request->input('uang_diterima');

        // VALIDASI UANG CUKUP
        if ($uangDiterima < $transaksi->total_harga) {
            return back()->with('error', 'Uang yang diterima tidak mencukupi.');
        }

        $kembalian = $uangDiterima - $transaksi->total_harga;

        // UPDATE STATUS TRANSAKSI
        $transaksi->update([
            'status' => 'paid',
            'metode_pembayaran' => 'cash',
            'uang_diterima' => $uangDiterima,
            'kembalian' => $kembalian,
        ]);

        return redirect()->route('pos.strukpesanan', $transaksi->id)
            ->with('success', 'Pembayaran tunai berhasil diproses.');
    }

    // PEMBAYARAN QRIS (STATIS)
    public function bayarQris(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // KEAMANAN
        if ($transaksi->toko_id !== Auth::user()->toko_id) {
            abort(403);
        }

        // CEK STATUS
        if ($transaksi->status === 'paid') {
            return back()->with('error', 'Transaksi sudah dibayar.');
        }

        // UPDATE STATUS TRANSAKSI
        $transaksi->update([
            'status' => 'paid',
            'metode_pembayaran' => 'qris',
            'uang_diterima' => $transaksi->total_harga,
            'kembalian' => 0,
        ]);

        return redirect()->route('pos.strukpesanan', $transaksi->id)
            ->with('success', 'Pembayaran QRIS berhasil dikonfirmasi.');
    }

    // TAMPILKAN STRUK    
    public function showStruk($id)
    {
        $transaksi = Transaksi::with(['detailTransaksis.produk', 'kasir', 'toko'])
            ->findOrFail($id);
                    
        if ($transaksi->toko_id !== Auth::user()->toko_id) {
            abort(403, 'Akses ditolak.');
        }

        return view('pos.strukpesanan', compact('transaksi'));
    }

    public function resep()
    {
        $tokoId = Auth::user()->toko_id;

        $semuaProduk = Produk::where('toko_id', $tokoId)->get();

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

        $totalPenjualan = $transaksis->where('status', 'paid')->sum('total_harga'); 

        $transaksisPaginated = Transaksi::where('toko_id', Auth::user()->toko->id)
            ->whereDate('waktu_transaksi', $today) 
            ->with(['detailTransaksis', 'kasir'])
            ->orderBy('waktu_transaksi', 'asc')
            ->paginate(15);

        return view('pos.transaksi', [
            'transaksis' => $transaksisPaginated, 
            'totalPenjualan' => $totalPenjualan,
            'allTransaksis' => $transaksis->toJson()
        ]);
    }

    /**
     * Generate kode transaksi unik
     * Format: TRX-YYYYMMDD-XXXXX
     * Contoh: TRX-20251211-00001
     */
    private function generateKodeTransaksi($tokoId)
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = "TRX-{$date}-";
        
        // CARI TRANSAKSI TERAKHIR HARI INI UNTUK TOKO INI
        $lastTransaction = Transaksi::where('toko_id', $tokoId)
            ->whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();
        
        // GENERATE NOMOR URUT
        if ($lastTransaction && strpos($lastTransaction->kode_transaksi, $prefix) === 0) {
            // AMBIL NOMOR URUT TERAKHIR
            $lastNumber = (int) substr($lastTransaction->kode_transaksi, -5);
            $newNumber = $lastNumber + 1;
        } else {
            // MULAI DARI 1 JIKA BELUM ADA TRANSAKSI HARI INI
            $newNumber = 1;
        }
        
        // FORMAT DENGAN PADDING 5 DIGIT (00001, 00002, dst)
        $kodeTransaksi = $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        
        // CEK APAKAH KODE SUDAH ADA (SAFETY CHECK)
        $exists = Transaksi::where('kode_transaksi', $kodeTransaksi)->exists();
        
        if ($exists) {
            // JIKA SUDAH ADA, GUNAKAN TIMESTAMP UNTUK MEMASTIKAN UNIQUE
            $kodeTransaksi = $prefix . Carbon::now()->format('His') . '-' . rand(100, 999);
        }
        
        return $kodeTransaksi;
    }
}