@extends('layouts.app')
@section('title', 'Dashboard Admin Toko')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-extrabold text-primary">Dashboard Admin Toko</h1>
            <p class="text-gray-600 mt-2">
                Kelola toko dan kasir Anda dengan mudah melalui pusat kontrol ini.
            </p>
        </div>

        {{-- Avatar user --}}
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="font-semibold">{{ Auth::user()->name }}</p>
                <span class="text-sm text-gray-500">{{ Auth::user()->role}}</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- CARD TOKO --}}
        <div class="p-6 rounded-xl shadow-md bg-white border border-gray-200">
            <h2 class="text-xl font-bold text-primary mb-3">Manajemen {{ Auth::user()->toko->nama_toko }}</h2>
            <p class="text-gray-700 font-medium mb-5">Ayo kelola informasi toko Anda di sini.</p>

            {{-- Tombol Lihat Toko --}}
            <a href="{{ route('toko.dashboard') }}"
               class="inline-block font-semibold bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-lg transition">
               Lihat Toko
            </a>
        </div>

        {{-- CARD KASIR --}}
        <div class="p-6 rounded-xl shadow-md bg-white border border-gray-200">
            <h2 class="text-xl font-bold text-primary mb-3">Manajemen Kasir</h2>
            <p class="text-gray-700 font-medium mb-5">Tambahkan atau kelola akun kasir toko Anda.</p>

            {{-- Tombol Lihat Kasir --}}
            <a href="{{ route('kasir.dashboard') }}"
               class="inline-block bg-secondary font-semibold hover:bg-accent text-white px-4 py-2 rounded-lg transition">
               Lihat Kasir
            </a>            
        </div>

    </div>

</div>
@endsection
