<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KasirController;

// ---------------------------
// Landing Page
// ---------------------------
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [HomeController::class,'about'])->name('about');
Route::get('/contact', [HomeController::class,'contact'])->name('contact');

// ---------------------------
// Auth Routes
// ---------------------------
Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register']);

// ---------------------------
// Routes untuk user yang sudah login
// ---------------------------
Route::middleware('auth')->group(function () {

    // Dashboard sesuai role
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    // ---------------------------
    // Admin Toko: Daftarkan Toko
    // ---------------------------
    Route::middleware('role:admin_toko')->group(function () {
        Route::get('/toko/create', [TokoController::class,'create'])->name('toko.create');
        Route::post('/toko/store', [TokoController::class,'store'])->name('toko.store');
    });

    // ---------------------------
    // Admin Toko / Super Admin: Daftarkan Kasir
    // ---------------------------
    Route::middleware(['auth', 'role:admin_toko,super_admin'])->group(function () {
        Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create');
        Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store');
    });

});
