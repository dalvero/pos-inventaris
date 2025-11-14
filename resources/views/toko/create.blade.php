@extends('layouts.app')

@section('title', 'Daftarkan Toko')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-surface rounded-lg shadow-card">
    <h2 class="text-2xl font-bold text-primary mb-6 text-center">Daftarkan Toko</h2>
    <form action="{{ route('toko.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="nama_toko" placeholder="Nama Toko" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <input type="text" name="alamat" placeholder="Alamat Toko" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <input type="text" name="telepon" placeholder="No. Telepon" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
        <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white px-4 py-3 rounded-md">Daftarkan Toko</button>
    </form>
</div>
@endsection
