{{-- @extends('layouts.app')

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
@endsection --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS & Inventory')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-whitebg font-sans text-gray-700 font-semibold">

    <div class="max-w-md mx-auto mt-15 p-6 bg-graybg border border-gray-700 rounded-lg">
        {{-- LOGO CONTAINER --}}
        <div class="flex justify-center mb-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto">
        </div>   
        <h2 class="text-2xl font-bold text-primary mb-6 text-center">Register Sebagai Kasir</h2>
        <form action="{{ route('kasir.store') }}" method="POST" class="space-y-2">
            @csrf
            <input type="text" name="name" placeholder="Nama Kasir" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <input type="email" name="email" placeholder="Email Kasir" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <input type="nama_toko" name="nama_toko" placeholder="Nama Toko" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">        

            <button type="submit" class="w-full bg-primary text-2xl font-semibold cursor-pointer hover:bg-primary-hover text-white px-4 py-3 rounded-md">Register</button>
            {{-- SUDAH PUNYA AKUN? LOGIN --}}
            <p class="text-center mt-4 text-base">
                Sudah punya akun?
                <a href="{{ route('login')}}" class="text-primary font-semibold hover:text-primary-hover">Login</a>
            </p>
        </form>
    </div>
</body>
</html>



