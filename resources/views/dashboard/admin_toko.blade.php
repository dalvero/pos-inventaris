@extends('layouts.app')
@section('title','Dashboard Admin Toko')
@section('content')
<h1 class="text-3xl font-bold text-primary">Halo Admin Toko</h1>
<p class="mt-4">Ini dashboard untuk mengelola toko dan kasir.</p>
<a href="{{ route('toko.create') }}" class="bg-secondary hover:bg-accent text-white px-4 py-2 rounded-md mt-4 inline-block">Daftarkan Toko</a>
<a href="{{ route('kasir.create') }}" class="bg-secondary hover:bg-accent text-white px-4 py-2 rounded-md mt-4 inline-block">Daftarkan Kasir</a>
@endsection
