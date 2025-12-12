<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalToko = Toko::count();
        $totalAdminToko = User::where('role', 'admin_toko')->count();
        $totalKasir = User::where('role', 'kasir')->count();
        
        $userTerbaru = User::with('toko')
            ->latest()
            ->take(5)
            ->get();
        
        $tokoTerbaru = Toko::with('admin')
            ->latest()
            ->take(5)
            ->get();
        
        return view('super_admin.dashboard', compact(
            'totalUsers',
            'totalToko',
            'totalAdminToko',
            'totalKasir',
            'userTerbaru',
            'tokoTerbaru'
        ));
    }

    // KELOLA USER    
    // MENAMPILKAN DAFTAR USER
    public function indexUsers()
    {
        $users = User::with('toko')->latest()->paginate(10);
        return view('super_admin.users.index', compact('users'));
    }

    // FORM TAMBAH USER
    public function createUser()
    {
        $tokos = Toko::all();
        return view('super_admin.users.create', compact('tokos'));
    }

    // SIMPAN USER BARU
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,kasir',
            'toko_id' => 'nullable|exists:tokos,id'
        ]);

        // VALIDASI toko_id HARUS ADA JIKA ROLE ADMIN ATAU KASIR
        if (in_array($request->role, ['admin', 'kasir']) && !$request->toko_id) {
            return back()->withErrors(['toko_id' => 'Toko harus dipilih untuk role Admin atau Kasir'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'toko_id' => $request->toko_id
        ]);

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // FORM EDIT USER
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $tokos = Toko::all();
        return view('super_admin.users.edit', compact('user', 'tokos'));
    }

    // UPDATE USER
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,kasir',
            'toko_id' => 'nullable|exists:tokos,id'
        ]);

        // VALIDASI toko_id HARUS ADA JIKA ROLE ADMIN ATAU KASIR
        if (in_array($request->role, ['admin', 'kasir']) && !$request->toko_id) {
            return back()->withErrors(['toko_id' => 'Toko harus dipilih untuk role Admin atau Kasir'])->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'toko_id' => $request->toko_id
        ]);

        // UPDATE PASSWORD JIKA DIISI
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil diupdate!');
    }

    // HAPUS USER
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        // CEK APAKAH USER ADALAH SUPER ADMIN TERAKHIR
        if ($user->role === 'super_admin') {
            $superAdminCount = User::where('role', 'super_admin')->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Tidak dapat menghapus super admin terakhir!');
            }
        }

        $user->delete();
        return redirect()->route('super_admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    // KELOLA TOKO    
    // MENAMPILKAN DAFTAR TOKO
    public function indexTokos()
    {
        $tokos = Toko::with('admin')->latest()->paginate(10);
        return view('super_admin.tokos.index', compact('tokos'));
    }

    // FORM TAMBAH TOKO
    public function createToko()
    {
        // AMBIL USER YANG ROLE ADMIN DAN BELUM PUNYA TOKO
        $admins = User::where('role', 'admin')
            ->whereDoesntHave('toko', function($query) {
                $query->whereColumn('tokos.user_id', 'users.id');
            })
            ->get();
        
        return view('super_admin.tokos.create', compact('admins'));
    }

    // SIMPAN TOKO BARU
    public function storeToko(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'user_id' => 'required|exists:users,id',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // CEK APAKAH ADMIN SUDAH PUNYA TOKO
        $adminHasToko = Toko::where('user_id', $request->user_id)->exists();
        if ($adminHasToko) {
            return back()->withErrors(['user_id' => 'Admin ini sudah memiliki toko'])->withInput();
        }

        $data = $request->except('qr_image');

        // UPLOAD QR IMAGE JIKA ADA
        if ($request->hasFile('qr_image')) {
            $file = $request->file('qr_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/qr_images', $filename);
            $data['qr_image'] = $filename;
        }

        Toko::create($data);

        return redirect()->route('super_admin.tokos.index')->with('success', 'Toko berhasil ditambahkan!');
    }

    // FORM EDIT TOKO
    public function editToko($id)
    {
        $toko = Toko::findOrFail($id);
        
        // AMBIL USER YANG ROLE ADMIN DAN BELUM PUNYA TOKO
        $admins = User::where('role', 'admin')
            ->where(function($query) use ($id) {
                $query->whereDoesntHave('toko', function($q) {
                    $q->whereColumn('tokos.user_id', 'users.id');
                })
                ->orWhere('id', Toko::find($id)->user_id);
            })
            ->get();
        
        return view('super_admin.tokos.edit', compact('toko', 'admins'));
    }

    // UPDATE TOKO
    public function updateToko(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);
        
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'user_id' => 'required|exists:users,id',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // CEK APAKAH ADMIN SUDAH PUNYA TOKO LAIN
        $adminHasToko = Toko::where('user_id', $request->user_id)
            ->where('id', '!=', $id)
            ->exists();
        if ($adminHasToko) {
            return back()->withErrors(['user_id' => 'Admin ini sudah memiliki toko lain'])->withInput();
        }

        $data = $request->except('qr_image');

        // UPLOAD QR IMAGE BARU JIKA ADA
        if ($request->hasFile('qr_image')) {
            // HAPUS GAMBAR LAMA JIKA ADA
            if ($toko->qr_image) {
                Storage::delete('public/qr_images/' . $toko->qr_image);
            }
            
            $file = $request->file('qr_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/qr_images', $filename);
            $data['qr_image'] = $filename;
        }

        $toko->update($data);

        return redirect()->route('super_admin.tokos.index')->with('success', 'Toko berhasil diupdate!');
    }

    // HAPUS TOKO 
    public function destroyToko($id)
    {
        $toko = Toko::findOrFail($id);
        
        // HAPUS QR IMAGE JIKA ADA
        if ($toko->qr_image) {
            Storage::delete('public/qr_images/' . $toko->qr_image);
        }

        $toko->delete();
        
        return redirect()->route('super_admin.tokos.index')->with('success', 'Toko berhasil dihapus!');
    }
}