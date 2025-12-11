@extends('kasir.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard Kasir
        </h2>
        <p class="text-sm font-semibold text-gray-600">
            Berikut adalah overview dan statistik kasir di {{Auth::user()->toko->nama_toko}} milik anda.
        </p>
    </div>

        
    <div class="mt-12">
        <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-3">
            <!-- INFO TOTAL KASIR CARD -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-green-600 to-green-400 text-white shadow-green-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Total Kasir</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{Auth::user()->toko->kasirs()->count()}}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    {{-- CEK KASIR YANG SEDANG BERTUGAS (SHIFT OPENING) --}}
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-blue-500">{{Auth::user()->toko->kasirs()->count()}}</strong>&nbsp;bekerja di toko anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- KASIR YANG SEDANG BERTUGAS --}}
        <div class="mt-12">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Kasir Sedang Bertugas</h3>

            <div class="grid gap-y-6 gap-x-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($kasirAktif as $shift)
                    @php $kasir = $shift->kasir; @endphp

                    <div class="relative flex flex-col bg-white rounded-xl text-gray-700 shadow-md hover:shadow-lg transition duration-300">
                        <div class="p-6 flex flex-col items-center">

                            {{-- FOTO KASIR --}}
                            <img class="object-center object-cover rounded-full h-28 w-28 ring-4 ring-green-200 mb-4"
                                src="{{ $kasir->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($kasir->name) }}"
                                alt="{{ $kasir->name }}">

                            {{-- NAMA & ROLE --}}
                            <div class="text-center">
                                <p class="text-lg text-gray-900 font-bold mb-1">{{ $kasir->name }}</p>
                                <p class="text-sm text-gray-500 font-medium">{{ $kasir->role }}</p>
                            </div>

                            {{-- STATUS SHIFT --}}
                            <div class="mt-3 px-3 py-1 text-xs rounded-lg bg-green-100 text-green-700 font-semibold">
                                Sedang Bertugas (Opening: {{ \Carbon\Carbon::parse($shift->opening)->format('H:i') }})
                            </div>

                        </div>

                        {{-- TOMBOL DETAIL --}}
                        <div class="border-t border-gray-100 px-6 py-3 flex justify-center">
                            <button 
                                onclick="openDetailKasir({{ $kasir->id }}, '{{ $kasir->name }}', '{{ $kasir->email }}', '{{ $kasir->created_at }}', '{{ $kasir->updated_at }}')"
                                class="cursor-pointer text-sm font-semibold text-blue-600 hover:text-blue-700 hover:bg-blue-100 py-2 px-3 rounded-lg transition w-full text-center">
                                Detail
                            </button>
                        </div>
                    </div>

                @empty
                    <p class="text-gray-500 text-center col-span-full py-6">
                        Tidak ada kasir yang sedang bertugas.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
