@extends('pos.layout')

@section('content')

{{-- STYLE UNTUK CETAK STRUK --}}
@section('pos_header')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background-color: white;
            margin: 0;
            padding: 0;
        }
        .struk-container {
            width: 80mm;
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
            box-shadow: none !important;
        }
        .p-4 {
            padding: 0;
        }
    }

    @media screen {
        .struk-container {
            max-width: 400px;
            margin: 20px auto;
        }
    }

    .struk-dotted {
        border-top: 2px dashed #333;
        margin: 10px 0;
    }
</style>
@endsection

<div class="p-4 xl:ml-0">
    {{-- HEADER DENGAN TOMBOL AKSI --}}
    <div class="mb-6 flex justify-between items-center no-print">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Struk Pesanan</h2>
            <p class="text-sm text-gray-600">ID Transaksi: #{{ $transaksi->id }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('pos.transaksi') }}" 
               class="px-4 py-2 bg-gray-500 text-white rounded-lg font-semibold shadow hover:bg-gray-600 transition">
                Kembali
            </a>
            <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                Cetak Struk
            </button>
        </div>
    </div>

    {{-- CONTAINER STRUK --}}
    <div class="struk-container bg-white rounded-xl shadow-lg p-6">
        {{-- HEADER TOKO --}}
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold text-gray-800">{{ $transaksi->toko->nama_toko ?? 'Nama Toko' }}</h1>
            <p class="text-xs text-gray-600">{{ $transaksi->toko->alamat ?? 'Alamat Toko' }}</p>
            <p class="text-xs text-gray-600">Telp: {{ $transaksi->toko->telepon ?? '-' }}</p>
        </div>

        <div class="struk-dotted"></div>

        {{-- INFO TRANSAKSI --}}
        <div class="mb-4 text-sm">
            <div class="flex justify-between mb-1">
                <span class="text-gray-600">No. Transaksi:</span>
                <span class="font-semibold">{{ $transaksi->kode_transaksi }}</span>
            </div>
            <div class="flex justify-between mb-1">
                <span class="text-gray-600">Tanggal:</span>
                <span>{{ $transaksi->waktu_transaksi->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between mb-1">
                <span class="text-gray-600">Kasir:</span>
                <span>{{ $transaksi->kasir->name ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pelanggan:</span>
                <span>{{ $transaksi->nama_pelanggan ?? 'Umum' }}</span>
            </div>
        </div>

        <div class="struk-dotted"></div>

        {{-- DETAIL PESANAN --}}
        <div class="mb-4">
            <h3 class="font-bold text-sm mb-3 text-gray-800">Detail Pesanan</h3>
            
            @foreach($transaksi->detailTransaksis as $detail)
            <div class="mb-3 text-sm">
                <div class="flex justify-between font-semibold">
                    <span>{{ $detail->produk->nama_produk ?? 'Produk' }}</span>
                </div>
                <div class="flex justify-between text-gray-600 mt-1">
                    <span>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                    <span class="font-semibold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="struk-dotted"></div>

        {{-- TOTAL --}}
        <div class="mb-4">
            <div class="flex justify-between text-lg font-bold mb-2">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>

            @if($transaksi->status === 'paid')
                <div class="text-sm">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Metode Pembayaran:</span>
                        <span class="font-semibold uppercase">{{ $transaksi->metode_pembayaran }}</span>
                    </div>
                    
                    @if($transaksi->metode_pembayaran === 'cash')
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Uang Diterima:</span>
                        <span>Rp {{ number_format($transaksi->uang_diterima, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kembalian:</span>
                        <span class="font-semibold">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>
            @else
                <div class="bg-yellow-100 text-yellow-800 text-center py-2 rounded text-sm font-semibold">
                    STATUS: BELUM DIBAYAR
                </div>
            @endif
        </div>

        <div class="struk-dotted"></div>

        {{-- FOOTER --}}
        <div class="text-center text-xs text-gray-600 mt-4">
            <p class="mb-1">Terima kasih atas kunjungan Anda</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            <p class="mt-2 font-semibold">Selamat berbelanja kembali!</p>
        </div>

        {{-- STATUS BADGE TAMPIL DI LAYAR SAJA --}}
        @if($transaksi->status === 'paid')
        <div class="mt-6 no-print">
            <div class="bg-green-100 border-2 border-green-500 text-green-800 text-center py-3 rounded-lg">
                <span class="font-bold text-lg">✓ LUNAS</span>
            </div>
        </div>
        @endif
    </div>

    {{-- TOMBOL AKSI BAWAH TAMPIL DI LAYAR SAJA --}}
    <div class="mt-6 text-center no-print">
        <div class="flex justify-center gap-3">
            <a href="{{ route('pos.menupesanan') }}" 
               class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition">
                Transaksi Baru
            </a>
            <a href="{{ route('pos.transaksi') }}" 
               class="px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold shadow hover:bg-gray-700 transition">
                Lihat Semua Transaksi
            </a>
        </div>
    </div>
</div>

@endsection