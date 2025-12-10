@extends('pos.layout')

@section('content')

{{-- Tambahkan style untuk cetak --}}
@section('pos_header')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background-color: white;
        }
        .p-4 {
            padding: 0;
        }
    }
</style>
@endsection

<div class="p-4 xl:ml-0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
            {{--<p class="text-sm font-semibold text-gray-600">
                Lihat hasil penjualanmu di sini
            </p>--}}
        </div>

        {{-- TOMBOL BARU: CETAK LAPORAN HARIAN (MENGGANTIKAN CLOSING) --}}
        <button onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold shadow hover:bg-blue-700 transition no-print">
            Cetak Laporan Harian
        </button>
    </div>

    {{-- KARTU RINGKASAN TOTAL PENJUALAN --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Penjualan Hari Ini</h3>
        <p class="text-4xl font-extrabold text-green-600">
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </p>
    </div>

    {{-- TABEL TRANSAKSI --}}
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Daftar Transaksi ({{ count($transaksis) }} Data)</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">#{{ $transaksi->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $transaksi->waktu_transaksi->format('H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $transaksi->nama_pelanggan ?? 'Umum' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $transaksi->kasir->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-900">
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium no-print">
                                {{-- Tombol untuk melihat detail / cetak struk per item --}}
                                <a href="{{ route('pos.struk', ['id' => $transaksi->id]) }}" target="_blank"
                                   class="text-indigo-600 hover:text-indigo-900 transition">
                                    Detail / Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Paginasi --}}
        <div class="mt-4">
            {{ $transaksisPaginated->links() }}
        </div>
    </div>
</div>

@endsection