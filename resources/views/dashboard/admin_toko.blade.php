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
            <h2 class="text-xl font-bold text-primary mb-3">Manajemen Toko</h2>
            <p class="text-gray-700 mb-5">Kelola informasi toko Anda di sini.</p>

            @if(Auth::user()->toko)
                <a href="{{ route('toko.edit', Auth::user()->toko->id) }}"
                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg transition">
                    Edit Data Toko
                </a>
            @else
                <a href="{{ route('toko.create') }}"
                   class="inline-block bg-primary hover:bg-primary/80 text-white font-medium px-4 py-2 rounded-lg transition">
                    Daftarkan Toko
                </a>
            @endif
        </div>

        {{-- CARD KASIR --}}
        <div class="p-6 rounded-xl shadow-md bg-white border border-gray-200">
            <h2 class="text-xl font-bold text-primary mb-3">Manajemen Kasir</h2>
            <p class="text-gray-700 mb-5">Tambahkan atau kelola akun kasir yang bekerja di toko Anda.</p>

            <a href="{{ route('kasir.create') }}"
               class="inline-block bg-secondary hover:bg-accent text-white font-medium px-4 py-2 rounded-lg transition">
                Daftarkan Kasir
            </a>
        </div>

    </div>

</div>
@endsection
