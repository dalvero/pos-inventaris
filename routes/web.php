<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KasirController;

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

    // ADMIN TOKO dan SUPER ADMIN
    Route::middleware('role:admin_toko,super_admin')->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
        Route::get('/kasir/create', [KasirController::class, 'create'])->name('kasir.create');
        Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store');
    });

});
