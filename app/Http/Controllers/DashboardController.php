<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // MENAMPILKAN DASHBOARD BERDASARKAN ROLE USER
    public function index() {
        // AMBIL DATA USER YANG SEDANG LOGIN
        $user = Auth::user();        
        if ($user->role === 'super_admin') return view('dashboard.super_admin');
        if ($user->role === 'admin_toko') return view('dashboard.admin_toko');
        if ($user->role === 'kasir') return view('dashboard.kasir');
        // JIKA BUKAN SUPER ADMIN, ADMIN TOKO, ATAU KASIR MAKA ABORT 403
        abort(403);
    }
}
