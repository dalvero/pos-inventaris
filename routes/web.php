<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\ResepProdukController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShiftController;

// LANDING PAGE
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('about');
Route::get('/contact', [HomeController::class,'contact'])->name('contact');

// AUTH
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register']);

// USER HARUS LOGIN
Route::middleware('auth')->group(function () {

    // Dashboard umum
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    // ADMIN TOKO
    Route::middleware('role:admin_toko')->group(function () {
        Route::get('/toko/dashboard', [TokoController::class, 'dashboard'])->name('toko.dashboard');
        Route::get('/toko/kasir', [TokoController::class, 'listKasir'])->name('toko.kasir');
        Route::get('/toko/create', [TokoController::class,'create'])->name('toko.create');
        Route::post('/toko/store', [TokoController::class,'store'])->name('toko.store');
        Route::get('/toko/{id}/edit', [TokoController::class,'edit'])->name('toko.edit');
        Route::put('/toko/{id}', [TokoController::class,'update'])->name('toko.update');
    });

    // ADMIN TOKO DAN SUPER ADMIN
    Route::middleware('role:admin_toko,super_admin')->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
        Route::get('/kasir/kasir', [KasirController::class, 'listKasir'])->name('kasir.kasir');        
        Route::get('/kasir/{id}', [KasirController::class, 'show'])->name('kasir.show');    
        Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store');
        Route::delete('/kasir/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
        
        // PRODUK
        Route::get('/produk/dashboard', [ProdukController::class, 'dashboard']) -> name('produk.dashboard');
        Route::get('/produk/produk', [ProdukController::class, 'listProduk'])->name('produk.produk'); 
        Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        
        // RESEP PRODUK
        Route::get('/resep/resep', [ResepProdukController::class, 'listResep'])->name('resep.resep');
        Route::post('/resep', [ResepProdukController::class, 'store'])->name('resep.store');
        Route::get('/resep/search', [ResepProdukController::class, 'search'])->name('resep.search');
        Route::delete('/resep/{id}', [ResepProdukController::class, 'destroy'])->name('resep.destroy');
        Route::put('/resep/{id}', [ResepProdukController::class, 'update'])->name('resep.update');

        // BAHAN BAKU
        Route::get('/bahanbaku/dashboard', [BahanBakuController::class, 'dashboard'])->name('bahanbaku.dashboard');
        Route::get('/bahanbaku/bahanbaku', [BahanBakuController::class, 'listBahan'])->name('bahanbaku.bahanbaku');
        Route::get('/bahanbaku/create', [BahanBakuController::class, 'create'])->name('bahanbaku.create');
        Route::get('/bahanbaku/search', [BahanBakuController::class, 'search'])->name('bahanbaku.search');
        Route::post('/bahanbaku', [BahanBakuController::class, 'store'])->name('bahanbaku.store');        
        Route::get('/bahanbaku/{id}/edit', [BahanBakuController::class,'edit'])->name('bahanbaku.edit');
        Route::put('/bahanbaku/{id}', [BahanBakuController::class,'update'])->name('bahanbaku.update');
        Route::delete('/bahanbaku/{id}', [BahanBakuController::class, 'destroy'])->name('bahanbaku.destroy');
    });

    // KASIR DAN SUPERADMIN
    Route::middleware('role:kasir,super_admin')->group(function () {        
        Route::post('/kasir/opening', [ShiftController::class, 'opening'])->name('kasir.opening');
        Route::post('/kasir/closing', [ShiftController::class, 'closing'])->name('kasir.closing');
        
        // POS
        Route::get('/pos/menupesanan', [POSController::class, 'menupesanan'])->name('pos.menupesanan');
        Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
        
        // PEMBAYARAN
        Route::get('/pembayaran/{id}', [POSController::class, 'pembayaran'])->name('pos.pembayaran');
        Route::post('/pembayaran/{id}/cash', [POSController::class, 'bayarCash'])->name('pos.bayar.cash');
        Route::post('/pembayaran/{id}/qris', [POSController::class, 'bayarQris'])->name('pos.bayar.qris');
                
        // STRUK & TRANSAKSI
        Route::get('/struk-pesanan/{id}', [POSController::class, 'showStruk'])->name('pos.strukpesanan');
        Route::get('/pos/resep', [POSController::class, 'resep'])->name('pos.resep');
        Route::get('/pos/bahanbaku', [POSController::class, 'listBahan'])->name('pos.bahanbaku');
        Route::get('/transaksi', [POSController::class, 'listTransaksi'])->name('pos.transaksi');
    });

});