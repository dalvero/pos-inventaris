@extends('pos.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Bahan Baku Untuk Menumu
            </h2>
            <p class="text-sm font-semibold text-gray-600">
                Cek bahan baku untuk membuat menumu ya.
            </p>
        </div>         
    </div>

    {{-- TABLE CARD --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        {{-- TABLE HEADER --}}
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Bahan Baku</h3>
                {{-- ACTION FORM HARUS KE RUTE INDEX/LISTING UTAMA --}}
                <form action="{{ route('pos.bahanbaku') }}" method="GET">
                    {{-- SEARCH BAR --}}
                    <div class="relative">
                        <input 
                            type="text"
                            name="query"
                            {{-- $query sekarang dijamin ada di Controller --}}
                            value="{{ $query ?? '' }}" 
                            placeholder="Cari bahan baku..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute left-3 top-2.5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
            
                    {{-- Tambahkan tombol submit agar pencarian lebih intuitif --}}
                    <button type="submit" class="hidden"></button>
                </form>
            </div>
        </div>

        {{-- TABLE CONTENT --}}
        <div class="p-6 overflow-x-auto">
            <table class="w-full min-w-max table-auto text-left">
                <thead>
                    <tr>
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-sm text-center text-gray-900 font-semibold leading-none">
                                No
                            </p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-sm text-center text-gray-900 font-semibold leading-none">
                                Nama Bahan
                            </p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-sm text-center text-gray-900 font-semibold leading-none">
                                Stok
                            </p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-sm text-center text-gray-900 font-semibold leading-none">
                                Satuan
                            </p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-center text-sm text-gray-900 font-semibold leading-none">
                                Stok Minimum
                            </p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-sm text-gray-900 font-semibold leading-none">
                                Status
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahans as $index => $bahan)
                        @php
                            // MENENTUKAN STATUS STOK
                            if ($bahan->stok <= 0) {
                                $status = ['Habis', 'bg-red-100 text-red-800'];
                            } elseif ($bahan->stok <= $bahan->minimum_stok) {
                                $status = ['Menipis', 'bg-orange-100 text-orange-800'];
                            } else {
                                $status = ['Aman', 'bg-green-100 text-green-800'];
                            }
                        @endphp

                        <tr class="hover:bg-gray-50">
                            {{-- NOMOR --}}
                            <td class="p-4 border-b border-gray-200">
                                <p class="text-sm text-center text-gray-900">{{ $index + 1 }}</p>
                            </td>

                            {{-- NAMA BAHAN --}}
                            <td class="p-4 border-b border-gray-200">
                                <p class="text-sm text-center font-semibold text-gray-900">
                                    {{ $bahan->nama_bahan }}
                                </p>
                            </td>

                            {{-- STOK --}}
                            <td class="p-4 border-b border-gray-200">
                                <p class="text-sm text-center text-gray-900">
                                    {{ $bahan->stok }}
                                </p>
                            </td>

                            {{-- SATUAN --}}
                            <td class="p-4 border-b border-gray-200">
                                <p class="text-sm text-center text-gray-900">
                                    {{ $bahan->satuan }}
                                </p>
                            </td>

                            {{-- STOK MINIMUM --}}
                            <td class="p-4 border-b border-gray-200">
                                <p class="text-sm text-center text-gray-900">
                                    {{ $bahan->minimum_stok}}
                                </p>
                            </td>

                            {{-- STATUS --}}
                            <td class="p-4 border-b border-gray-200">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">
                                Belum ada data bahan baku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="p-6 border-t border-gray-200">
            {{ $bahans->links() }}
        </div>
    </div>
</div>

@endsection
