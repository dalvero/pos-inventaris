@extends('layouts.app')
@section('title','Dashboard Super Admin')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-extrabold text-primary">Dashboard Super Admin</h1>
            <p class="text-gray-600 mt-2">
                Kelola Sistem POS Inventaris mu di sini
            </p>
        </div>

        {{-- AVATAR --}}
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

        {{-- CARD DASHBOARD POINT OF SALE --}}
        <div class="p-6 rounded-xl shadow-md bg-white border border-gray-200">
            <h2 class="text-xl font-bold text-primary mb-3">Dashboard</h2>
            <p class="text-gray-700 font-medium mb-5">Ayo ke dashboard dan kelola sistem.</p>

            {{-- DASHBOARD --}}
            <a href="{{ route('super_admin.dashboard') }}"
            class="inline-block font-semibold bg-primary hover:bg-primary/80 text-white px-4 py-2 rounded-lg transition">
                Dashboard
            </a>
        </div>
    </div>

</div>
@endsection

