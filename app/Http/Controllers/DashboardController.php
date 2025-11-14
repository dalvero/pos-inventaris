<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        if ($user->role === 'super_admin') return view('dashboard.super_admin');
        if ($user->role === 'admin_toko') return view('dashboard.admin_toko');
        if ($user->role === 'kasir') return view('dashboard.kasir');
        abort(403);
    }
}
