<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // MENAMPILKAN HALAMAN LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        // VALIDASI INPUT
        $credentials = $request->only('email','password');

        // CEK KREDENSIAL DAN LOGIN
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            // JIKA BERHASIL LOGIN, MENAMPILKAN PESAN LOGIN BERHASIL
            return redirect()->route('dashboard')->with('success','Login berhasil!');
        }

        // JIKA GAGAL KEMBALI KE HALAMAN LOGIN DENGAN ERROR
        return back()->withErrors(['email'=>'Email atau password salah']);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // MENAMPILKAN HALAMAN REGISTER
    public function showRegister()
    {
        return view('auth.register');
    }

    // REGISTER PROSES
    public function register(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|confirmed|min:6',
        ]);

        // MEMBUAT USER BARU
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'kasir', // SET DEFAULT ROLE KASIR
            'toko_id'=>null // NANTI UPDATE JIKA SUDAH ADA TOKO            
        ]);

        // LOGIN OTOMATIS SETELAH REGISTER
        Auth::login($user);

        // REDIRECT KE DASHBOARD DENGAN PESAN SUKSES
        return redirect()->route('dashboard')->with('success','Akun berhasil dibuat!'); 
    }
}
