<?php
namespace App\Http\Controllers;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function create() { return view('toko.create'); }
    public function store(Request $request){
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'telepon' => 'required|string|max:20',
        ]);

        Toko::create([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('dashboard')->with('success','Toko berhasil didaftarkan!');
    }
}
