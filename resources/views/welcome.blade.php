@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="text-center mt-20">
    <h1 class="text-4xl font-bold text-primary mb-6">Selamat Datang di POS & Inventaris</h1>
    <p class="mb-8 text-lg text-muted">Sistem manajemen penjualan dan stok untuk usaha minuman/makanan.</p>
    <a href="{{ route('login') }}" class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-md shadow-soft">Login</a>
</div>
@endsection
