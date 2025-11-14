@extends('layouts.app')

@section('title', 'Register Kasir')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-surface rounded-lg shadow-card">
    <h2 class="text-2xl font-bold text-primary mb-6 text-center">Daftarkan Kasir</h2>
    <form action="{{ route('kasir.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="name" placeholder="Nama Kasir" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <input type="email" name="email" placeholder="Email Kasir" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">

        <select name="toko_id" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <option value="">Pilih Toko</option>
            @foreach(\App\Models\Toko::all() as $toko)
                <option value="{{ $toko->id }}">{{ $toko->nama_toko }}</option>
            @endforeach
        </select>

        <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white px-4 py-3 rounded-md">Daftarkan Kasir</button>
    </form>
</div>
@endsection
