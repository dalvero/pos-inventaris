<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    // MENAMPILKAN FORM PENDAFTARAN KASIR
    public function create() { return view('kasir.create'); }

    public function dashboard()
    {
        return view('kasir.dashboard');
    }


    // MENYIMPAN DATA KASIR BARU
    public function store(Request $request){
        // VALIDASI INPUT
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'toko_id' => 'required|exists:tokos,id',
        ]);

        // MEMBUAT USER KASIR BARU
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kasir',
            'toko_id' => $request->toko_id
        ]);

        // REDIRECT KE HALAMAN DASHBOARD DENGAN PESAN SUKSES
        return redirect()->route('dashboard')->with('success','Kasir berhasil didaftarkan!');
    }
}
