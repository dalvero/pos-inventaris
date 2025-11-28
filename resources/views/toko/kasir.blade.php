@extends('toko.layout')

@section('breadcrumb', 'kasir')
@section('page-title', 'Manajemen Kasir')

@section('content')
<div class="mt-6">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Kelola kasir di {{Auth::user()->toko->nama_toko}}
        </h2>
        <p class="text-sm font-semibold text-gray-600">
            Berikut adalah kasir yang terdaftar di {{Auth::user()->toko->nama_toko}} milik anda.
        </p>
    </div>

    {{-- GRID KASIR --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {{-- LOOPING KASIR --}}
        @forelse($kasirs as $kasir)
            <div class="relative flex flex-col bg-white rounded-xl text-gray-700 shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="p-6 flex flex-col justify-center items-center">
                    <div class="mb-4">
                        <img 
                            class="object-center object-cover rounded-full h-28 w-28 ring-4 ring-blue-100" 
                            src="{{ $kasir->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($kasir->name) }}" 
                            alt="{{ $kasir->name }}">
                    </div>
                    <div class="text-center">
                        <p class="text-lg text-gray-900 font-bold mb-1">{{ $kasir->name }}</p>
                        <p class="text-sm text-gray-500 font-medium mb-3">{{ $kasir->role ?? 'Kasir' }}</p>

                        {{-- STATUS SHIFT (OPENING/BREAK/CLOSING) --}}
                        <div class="flex items-center justify-center gap-2 text-xs text-gray-600">                            

                        </div>
                    </div>
                </div>

                {{-- DETAIL KASIR --}}
                <div class="border-t border-gray-100 px-6 py-3 justify-center flex gap-2">
                    {{-- <a href="{{ route('kasir.show', $kasir->id) }}"  --}}
                    <a href=""
                    class="flex-1 text-center text-sm font-semibold text-blue-600 hover:text-blue-700 hover:bg-blue-100 py-2 px-3 rounded-lg transition">
                        Detail
                    </a>
                </div>
            </div>
            @empty

            {{-- JIKA BELUM ADA KASIR --}}
            <div class="col-span-full text-center py-10 text-gray-500">
                Belum ada kasir terdaftar.
            </div>

        @endforelse

        {{-- CARD TAMBAH KASIR --}}
        
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-linear-to-br from-blue-50 to-indigo-50 border-2 border-dashed border-blue-300 text-gray-700 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer group">
            <a href="{{ route('kasir.dashboard') }}" class="block">
                <div class="p-6 flex flex-col justify-center items-center h-full">
                    <div class="mb-4 w-28 h-28 rounded-full bg-white flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div class="text-center">
                        <p class="text-lg text-gray-700 font-bold mb-1">Tambah Kasir</p>
                        <p class="text-sm text-gray-500 font-medium">Daftarkan kasir baru</p>
                    </div>
                </div>
            </a>
        </div>
    


        {{-- CARD TAMBAH KASIR
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-linear-to-br from-blue-50 to-indigo-50 border-2 border-dashed border-blue-300 text-gray-700 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer group">
            <div class="p-6 flex flex-col justify-center items-center h-full">
                <div class="mb-4 w-28 h-28 rounded-full bg-white flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-lg text-gray-700 font-bold mb-1">Tambah Kasir</p>
                    <p class="text-sm text-gray-500 font-medium">Daftarkan kasir baru</p>
                </div>
            </div>
        </div>

cara menambahkan href disini --}}

    </div>

    {{-- STATISTIK --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Kasir</h3>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{Auth::user()->toko->kasirs()->count()}}</p>
                <p class="text-xs text-gray-500 mt-1">Terdaftar di sistem</p>
            </div>
        </div>

        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Sedang Bertugas</h3>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">4</p>
                <p class="text-xs text-gray-500 mt-1">Kasir aktif hari ini</p>
            </div>
        </div>

        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Kinerja Hari Ini</h3>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-orange-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">89%</p>
                <p class="text-xs text-gray-500 mt-1">Tingkat produktivitas</p>
            </div>
        </div>
    </div>
</div>
@endsection