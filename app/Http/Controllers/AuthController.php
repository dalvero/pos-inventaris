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
        return view('auth.register', [
            'tokos' => \App\Models\Toko::all()
        ]);
    }

    // REGISTER PROSES
    public function register(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|confirmed|min:6',
            'role' => 'required|in:kasir,admin_toko',
        ]);

        $tokoId = null;

         // JIKA KASIR -> AMBIL toko_id DARI DROPDOWN
        if ($request->role === 'kasir') {
            $request->validate([
                'toko_id' => 'required|exists:tokos,id'
            ]);
            $tokoId = $request->toko_id;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'kasir',
                'toko_id' => $request->toko_id
            ]);
        }

        // JIKA ADMIN TOKO -> BUAT TOKO BARU
        if ($request->role === 'admin_toko') {
            $request->validate([
                'nama_toko' => 'required|unique:tokos,nama_toko'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin_toko',
                'toko_id' => null
            ]);

            $toko = \App\Models\Toko::create([
                'nama_toko' => $request->nama_toko,
                'user_id' => $user->id
            ]);

            $user->update([
                'toko_id' => $toko->id
            ]);

            $tokoId = $toko->id;
        }

        // LOGIN OTOMATIS SETELAH REGISTER
        Auth::login($user);

        // REDIRECT KE DASHBOARD DENGAN PESAN SUKSES
        return redirect()->route('dashboard')->with('success','Akun berhasil dibuat!'); 
    }
}
