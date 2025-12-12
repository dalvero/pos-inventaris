@extends('toko.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard {{Auth::user()->toko->nama_toko}}
        </h2>
        <p class="text-sm font-semibold text-gray-600">
            Berikut adalah overview dan statistik dari {{Auth::user()->toko->nama_toko}} milik anda.
        </p>
    </div>

    <!-- STATISTIK CARD -->
    <div class="mt-12">
        <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-4">
            <!-- CARD PENJUALAN HARI INI -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-orange-600 to-orange-400 text-white shadow-orange-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                        <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                        <path d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Penjualan Hari Ini</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                        Rp{{ number_format($penjualanHariIni ?? 0, 0, ',', '.') }}
                    </h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    @if($statusPerubahan === 'naik')
                        <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                            <strong class="text-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 inline">
                                    <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                                </svg>
                                +{{ number_format(abs($persentasePerubahan), 1) }}%
                            </strong>&nbsp;dari kemarin ({{ $jumlahTransaksiHariIni }} transaksi)
                        </p>
                    @elseif($statusPerubahan === 'turun')
                        <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                            <strong class="text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 inline">
                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd" />
                                </svg>
                                {{ number_format(abs($persentasePerubahan), 1) }}%
                            </strong>&nbsp;dari kemarin ({{ $jumlahTransaksiHariIni }} transaksi)
                        </p>
                    @elseif($statusPerubahan === 'netral')
                        <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                            <strong class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 inline">
                                    <path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />
                                </svg>
                                0%
                            </strong>&nbsp;sama dengan kemarin ({{ $jumlahTransaksiHariIni }} transaksi)
                        </p>
                    @else
                        <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                            <strong class="text-blue-500">{{ $jumlahTransaksiHariIni }}</strong>&nbsp;transaksi hari ini
                        </p>
                    @endif
                </div>
            </div>

            <!-- INFO PRODUK CARD -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-blue-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-6 h-6 text-white">
                        <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Total Produk</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{Auth::user()->toko->produks()->count()}}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-green-500">{{Auth::user()->toko->produks()->count()}}</strong>&nbsp;produk tersedia di toko anda.
                    </p>
                </div>
            </div>

            <!-- INFO BAHAN BAKU CARD -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-violet-600 to-violet-400 text-white shadow-violet-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Bahan Baku</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{Auth::user()->toko->bahanBakus()->count()}}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-green-500">{{Auth::user()->toko->bahanBakus()->count()}}</strong>&nbsp;tersedia di toko anda.
                    </p>
                </div>
            </div>

            <!-- INFO KASIR CARD -->
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
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-blue-500">{{ $kasirAktif->count() }}</strong>&nbsp;kasir sedang bertugas
                    </p>
                </div>
            </div>
        </div>    
    </div>

    {{-- TABEL PRODUK TERLARIS HARI INI --}}
    <div class="mt-8 mb-12">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            {{-- TABLE HEADER --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Produk Terlaris Hari Ini</h3>
                        <p class="text-xs text-gray-500 mt-1">Top 10 produk dengan penjualan tertinggi pada hari ini</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                        {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- TABLE CONTENT --}}
            <div class="p-6 overflow-x-auto">
                @if($produkTerlaris->count() > 0)
                    <table class="w-full min-w-max table-auto text-left">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[8%]">
                                    <p class="text-sm text-center font-semibold text-gray-900">Rank</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[35%]">
                                    <p class="text-sm font-semibold text-gray-900">Nama Produk</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[15%]">
                                    <p class="text-sm text-right font-semibold text-gray-900">Harga Satuan</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[15%]">
                                    <p class="text-sm text-center font-semibold text-gray-900">Jumlah Terjual</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[27%]">
                                    <p class="text-sm text-right font-semibold text-gray-900">Total Pendapatan</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produkTerlaris as $index => $produk)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 border-b border-gray-200 text-center">
                                        @if($index == 0)
                                            <span class="text-2xl">🥇</span>
                                        @elseif($index == 1)
                                            <span class="text-2xl">🥈</span>
                                        @elseif($index == 2)
                                            <span class="text-2xl">🥉</span>
                                        @else
                                            <p class="text-sm font-semibold text-gray-600">{{ $index + 1 }}</p>
                                        @endif
                                    </td>
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $produk->id }}</p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-right">
                                        <p class="text-sm text-gray-900">
                                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-center">
                                        <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                                            {{ $produk->total_terjual }} item
                                        </span>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-right">
                                        <p class="text-sm font-bold text-green-600">
                                            Rp{{ number_format($produk->total_pendapatan, 0, ',', '.') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        <p class="text-gray-500 font-semibold">Belum ada transaksi hari ini</p>
                        <p class="text-sm text-gray-400 mt-2">Data produk terlaris akan muncul setelah ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- TABEL PRODUK TERLARIS BULAN INI --}}    
    <div class="mt-8 mb-12">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            {{-- TABLE HEADER --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Produk Terlaris Bulan Ini</h3>
                        <p class="text-xs text-gray-500 mt-1">Top 10 produk dengan penjualan tertinggi bulan ini</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-violet-100 text-violet-800">
                        {{ now()->format('M Y') }}
                    </span>
                </div>
            </div>

            {{-- TABLE CONTENT --}}
            <div class="p-6 overflow-x-auto">
                @if($produkTerlarisBulan->count() > 0)
                    <table class="w-full min-w-max table-auto text-left">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[8%]">
                                    <p class="text-sm text-center font-semibold text-gray-900">Rank</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[35%]">
                                    <p class="text-sm font-semibold text-gray-900">Nama Produk</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[15%]">
                                    <p class="text-sm text-right font-semibold text-gray-900">Harga Satuan</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[15%]">
                                    <p class="text-sm text-center font-semibold text-gray-900">Jumlah Terjual</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4 w-[27%]">
                                    <p class="text-sm text-right font-semibold text-gray-900">Total Pendapatan</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produkTerlarisBulan as $index => $produk)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 border-b border-gray-200 text-center">
                                        @if($index == 0)
                                            <span class="text-2xl">🥇</span>
                                        @elseif($index == 1)
                                            <span class="text-2xl">🥈</span>
                                        @elseif($index == 2)
                                            <span class="text-2xl">🥉</span>
                                        @else
                                            <p class="text-sm font-semibold text-gray-600">{{ $index + 1 }}</p>
                                        @endif
                                    </td>
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $produk->id }}</p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-right">
                                        <p class="text-sm text-gray-900">
                                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-center">
                                        <span class="px-3 py-1 text-sm font-bold rounded-full bg-violet-100 text-violet-800">
                                            {{ $produk->total_terjual }} item
                                        </span>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-right">
                                        <p class="text-sm font-bold text-green-600">
                                            Rp{{ number_format($produk->total_pendapatan, 0, ',', '.') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <p class="text-gray-500 font-semibold">Belum ada transaksi bulan ini</p>
                        <p class="text-sm text-gray-400 mt-2">Data produk terlaris akan muncul setelah ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection