<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Shift;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
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

        // KASIR YANG SEDANG AKTIF (SHIFT OPENING)
        $kasirAktif = Shift::where('toko_id', $tokoId)
            ->whereNull('closing')
            ->with('kasir')
            ->get();

        // STATISTIK PENJUALAN HARI INI
        $hariIni = now()->format('Y-m-d');
        $kemarin = now()->subDay()->format('Y-m-d');

        // TOTAL PENJUALAN HARI INI
        $penjualanHariIni = Transaksi::where('toko_id', $tokoId)
            ->whereDate('waktu_transaksi', $hariIni)
            ->where('status', 'paid')
            ->sum('total_harga');

        // TOTAL PENJUALAN KEMARIN
        $penjualanKemarin = Transaksi::where('toko_id', $tokoId)
            ->whereDate('waktu_transaksi', $kemarin)
            ->where('status', 'paid')
            ->sum('total_harga');

        // HITUNG PRESENTASE PERUBAHAN
        $persentasePerubahan = 0;
        $statusPerubahan = 'netral'; // NETRAL, NAIK, TURUN, NO_DATA

        if ($penjualanKemarin > 0) {
            $persentasePerubahan = (($penjualanHariIni - $penjualanKemarin) / $penjualanKemarin) * 100;
            
            if ($persentasePerubahan > 0) {
                $statusPerubahan = 'naik';
            } elseif ($persentasePerubahan < 0) {
                $statusPerubahan = 'turun';
            } else {
                $statusPerubahan = 'netral';
            }
        } elseif ($penjualanHariIni > 0) {
            // JIKA KEMARIN TIDAK ADA DATA TAPI HARI INI ADA
            $statusPerubahan = 'no_data';
        }

        // JUMLAH TRANSAKSI HARI INI
        $jumlahTransaksiHariIni = Transaksi::where('toko_id', $tokoId)
            ->whereDate('waktu_transaksi', $hariIni)
            ->where('status', 'paid')
            ->count();

        // PRODUK TERLARIS (TOP 10)
        // AMBIL DARI DETAIL TRANSAKSI YANG DIGROUP BY produk_id
        $produkTerlaris = \DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->where('transaksis.toko_id', $tokoId)
            ->whereDate('transaksis.waktu_transaksi', $hariIni)
            ->where('transaksis.status', 'paid')
            ->select(
                'produks.id',
                'produks.nama_produk',
                'produks.harga',
                \DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'),
                \DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan')
            )
            ->groupBy('produks.id', 'produks.nama_produk', 'produks.harga')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();

        // PRODUK TERLARIS BULAN INI (TOP 10)
        $bulanIni = now()->format('Y-m');

        $produkTerlarisBulan = \DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->where('transaksis.toko_id', $tokoId)
            ->whereYear('transaksis.waktu_transaksi', now()->year)
            ->whereMonth('transaksis.waktu_transaksi', now()->month)
            ->where('transaksis.status', 'paid')
            ->select(
                'produks.id',
                'produks.nama_produk',
                'produks.harga',
                \DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'),
                \DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan')
            )
            ->groupBy('produks.id', 'produks.nama_produk', 'produks.harga')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();

        // UPDATE RETURN VIEW UNTUK MENAMBAHKAN $produkTerlarisBulan
        return view('toko.dashboard', compact(
            'kasirAktif',
            'penjualanHariIni',
            'penjualanKemarin',
            'persentasePerubahan',
            'statusPerubahan',
            'jumlahTransaksiHariIni',
            'produkTerlaris',
            'produkTerlarisBulan' 
        ));
        
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

    // TRANSAKSI TOKO    
    public function transaksiPenjualan(Request $request)
    {
        $tokoId = Auth::user()->toko_id;
        
        // AMBIL TANGGAL DARI REQUEST, DEFAULT KE HARI INI
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        
        // QUERY TRANSAKSI BERDASARKAN TANGGAL YANG DIPILIH
        $query = Transaksi::where('toko_id', $tokoId)
            ->whereDate('waktu_transaksi', $tanggal)
            ->with(['detailTransaksis.produk', 'kasir'])
            ->orderBy('waktu_transaksi', 'desc');
        
        // PAGINATE TRANSAKSI (10 ITEM PER TRANSAKSI, BUKAN PER ITEM)
        $transaksis = $query->paginate(10)->appends(['tanggal' => $tanggal]);
        
        // HITUNG TOTAL PENJUALAN PADA TANGGAL TERSEBUT
        $totalPenjualan = Transaksi::where('toko_id', $tokoId)
            ->whereDate('waktu_transaksi', $tanggal)
            ->where('status', 'paid')
            ->sum('total_harga');
        
        // AMBIL SEMUA TRANSAKSI UNTUK DATA JS (JIKA DIPERLUKAN)
        $allTransaksis = Transaksi::where('toko_id', $tokoId)
            ->whereDate('waktu_transaksi', $tanggal)
            ->with(['detailTransaksis.produk'])
            ->get();
        
        return view('toko.transaksi', compact('transaksis', 'totalPenjualan', 'tanggal', 'allTransaksis'));
    }
}
