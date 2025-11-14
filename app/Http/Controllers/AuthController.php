<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login process
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success','Login berhasil!');
        }

        return back()->withErrors(['email'=>'Email atau password salah']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Register process
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|confirmed|min:6',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'kasir', // default role
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success','Akun berhasil dibuat!');
    }
}
