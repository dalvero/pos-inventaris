<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // MENAMPILKAN HALAMAN LOGIN
    public function showLogin()
    {
        // INI ADALAH HALAMAN LOGIN
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

    // LUPA PASSWORD
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // KIRIM RESET LINK    
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar']);
        }

        // HAPUS TOKEN LAMA JIKA ADA
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // GENERATE TOKE BARU
        $token = Str::random(60);

        // SIMPAN TOKEN KE DATABASE
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // BUAT RESET LINK
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        // DATA UNTUK EMAIL
        $emailData = [
            'userName' => $user->name ?? 'Pengguna',
            'resetLink' => $resetLink
        ];

        // KIRIM EMAIL DENGAN TEMPLATE BLADE
        Mail::send('emails.reset-password', $emailData, function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password - POS & Inventory');
        });

        return back()->with('status', 'Tautan reset kata sandi telah dikirim ke email Anda');
    }

    // FORM RESET PASSWORD
    public function showResetPassword(Request $request, $token)
    {
        return response()
            ->view('auth.reset-password', [
                'token' => $token,
                'email' => $request->email
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


    // PROSES RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->where('created_at', '>=', Carbon::now()->subMinutes(60))
            ->first();

        if (!$record) {
            return back()->with('error', 'Token tidak valid');
        }

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('success', 'Password berhasil direset');
    }
}
