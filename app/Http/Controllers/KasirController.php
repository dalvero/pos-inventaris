<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class KasirController extends Controller
{
    // MENAMPILKAN FORM PENDAFTARAN KASIR
    public function create() { return view('kasir.create'); }

    public function dashboard()
    {
        $tokoId = Auth::user()->toko_id;

        $kasirAktif = Shift::where('toko_id', $tokoId)
            ->whereNull('closing')
            ->with('kasir')
            ->get();

        return view('kasir.dashboard',compact('kasirAktif'));
    }

    // MENAMPILKAN LIST KASIR
    public function listKasir(){
        $kasirs = Auth::user()->toko->kasirs;

        $tokoId = Auth::user()->toko_id;

        // AMBIL SHIFT AKTIF (CLOSING NULL)
        $kasirAktif = Shift::where('toko_id', $tokoId)
            ->whereNull('closing')
            ->pluck('kasir_id')  // HANYA AMBIL ID KASIR
            ->toArray();

        return view('kasir.kasir', compact('kasirs', 'kasirAktif'));
    }

    // MENYIMPAN DATA KASISR BARU
    public function store(Request $request){
        // VALIDASI DASAR
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        // CEK ROLE YANG SEDANG LOGIN
        $role = Auth::check() ? Auth::user()->role : null;

        // JIKA ADMIN TOKO -> toko_id DIAMBIL DARI TOKO ADMIN TOKO
        if ($role === 'admin_toko') {
            $tokoId = Auth::user()->toko->id;

        // JIKA SUPER ADMIN -> BISA PILIH TOKO DARI DROPDOWN
        } elseif ($role === 'super_admin') {
            $request->validate([
                'toko_id' => 'required|exists:tokos,id'
            ]);
            $tokoId = $request->toko_id;

        // JIKA TIDAK LOGIN (KASIR DAFTAR SENDIRI) -> PILIH TOKO VIA DROPDOWN
        } else {
            $request->validate([
                'toko_id' => 'required|exists:tokos,id'
            ]);
            $tokoId = $request->toko_id;
        }

        // CREATE USER KASIR
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'kasir',
            'toko_id'   => $tokoId,
        ]);

        return redirect()
            ->back()
            ->with('successCreate', 'Kasir berhasil ditambahkan!');
    }

    // MENGHAPUS KASIR
    public function destroy($id){
        $user = Auth::user();
        $kasir = User::findOrFail($id);

        // CEGAH HAPUS DIRI SENDIRI
        if ($user->id === $kasir->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // JIKA ADMIN TOKO → BOLEH HAPUS KASIR HANYA DI TOKONYA
        if ($user->role === 'admin_toko') {

            // CEK APAKAH KASIR INI MILIK TOKO ADMIN
            if ($kasir->toko_id !== $user->toko->id) {
                return back()->with('error', 'Anda tidak memiliki izin untuk menghapus kasir ini.');
            }

            $kasir->delete();
            return redirect()->back()->with('successDelete', 'Kasir berhasil dihapus');
        }

        // JIKA SUPER ADMIN → BOLEH HAPUS SEMUA KASIR
        if ($user->role === 'super_admin') {
            $kasir->delete();
            return redirect()->back()->with('successDelete', 'Kasir berhasil dihapus');
        }

        // ROLE LAIN DILARANG
        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus kasir.');
    }

    // MENAMPILKAN DETAIL KASIR
    public function show($id){
        $kasir = User::findOrFail($id);
        return view('kasir.show', compact('kasir'));
    }
}
