@extends('pos.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="p-4 xl:ml-0">
        {{-- HEADER --}}
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Transaksimu Hari Ini</h2>
                <p class="text-sm font-semibold text-gray-600">
                    Lihat hasil penjualanmu di sini
                </p>
            </div>

            <a href="{{ route('dashboard') }}">
                <button
                    class="px-4 py-2 bg-red-600 text-black rounded-lg font-bold shadow hover:bg-red-700 transition">
                    Closing
                </button>
            </a>
        </div>

        {{-- KARTU RINGKASAN TOTAL PENJUALAN --}}
    <div class="mb-6 bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Penjualan Hari Ini</h3>
        {{-- Menggunakan $totalPenjualan yang dihitung di controller --}}
        <p class="text-4xl font-extrabold text-violet-600">
            Rp{{ number_format($totalPenjualan ?? 0, 0, ',', '.') }},00
        </p>
    </div>

    {{-- TABLE CARD RIWAYAT ITEM TRANSAKSI --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        {{-- TABLE HEADER --}}
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Detail Item Penjualan (Per Pesanan)</h3>
            <p class="text-xs text-gray-500 mt-1">Data ditampilkan per item yang terjual, bukan per struk transaksi.</p>
        </div>

        {{-- TABLE CONTENT --}}
        <div class="p-6 overflow-x-auto">
            <table class="w-full min-w-max table-auto text-left">
                <thead>
                    <tr>
                        {{-- KOLOM BARU SESUAI PERMINTAAN USER --}}
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[5%]">
                            <p class="block antialiased font-sans text-sm text-center text-gray-900 font-semibold leading-none">No</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[25%]">
                            <p class="block antialiased font-sans text-sm text-gray-900 font-semibold leading-none">Pesanan (Nama Produk)</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[10%]">
                            <p class="block antialiased font-sans text-sm text-center text-gray-900 font-semibold leading-none">Jumlah</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[20%]">
                            <p class="block antialiased font-sans text-sm text-right text-gray-900 font-semibold leading-none">Harga Satuan</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[20%]">
                            <p class="block antialiased font-sans text-sm text-right text-gray-900 font-semibold leading-none">Total Harga</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[20%]">
                            <p class="block antialiased font-sans text-sm text-gray-900 font-semibold leading-none">Waktu Transaksi</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Counter untuk nomor urut baris (global counter) --}}
                    @php 
                        $globalIndex = ($transaksis->currentPage() - 1) * $transaksis->perPage(); 
                    @endphp

                    {{-- Loop data $transaksis (Transaksi utama) --}}
                    @forelse($transaksis as $transaksi)
                        {{-- Loop Detail Transaksi di dalam setiap Transaksi --}}
                        @foreach($transaksi->detailTransaksis as $detail)
                            @php 
                                $globalIndex++;
                                // Asumsi: detail memiliki kolom 'jumlah', 'harga_satuan', 'nama_produk', dan 'subtotal'
                                $hargaSatuan = $detail->harga_satuan ?? ($detail->subtotal / $detail->jumlah);
                                $totalHargaItem = $detail->subtotal ?? ($hargaSatuan * $detail->jumlah);
                            @endphp
                            <tr class="hover:bg-gray-50">
                                {{-- NOMOR --}}
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-center text-gray-900">{{ $globalIndex }}</p>
                                </td>

                                {{-- PESANAN (NAMA PRODUK) --}}
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $detail->nama_produk ?? 'Produk Dihapus' }}
                                    </p>
                                    <p class="text-xs text-gray-500">Struk ID: #{{ $transaksi->id }}</p> 
                                </td>

                                {{-- JUMLAH --}}
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-center text-gray-900">{{ $detail->jumlah }}</p>
                                </td>

                                {{-- HARGA SATUAN --}}
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-right text-gray-900">
                                        Rp{{ number_format($hargaSatuan, 0, ',', '.') }},00
                                    </p>
                                </td>
                                
                                {{-- TOTAL HARGA (SUBTOTAL ITEM) --}}
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-right font-bold text-green-600">
                                        Rp{{ number_format($totalHargaItem, 0, ',', '.') }},00
                                    </p>
                                </td>

                                {{-- WAKTU TRANSAKSI --}}
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d M Y, H:i:s') }}</p>
                                </td>
                            </tr>
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                Belum ada data transaksi hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        {{-- Peringatan: Pagination disini hanya mem-paginate Transaksi utama, bukan item. --}}
        <div class="p-6 border-t border-gray-200">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection

{{-- JAVASCRIPT: Dihapus karena tombol detail dan modal sudah tidak relevan di tampilan ini --}}
<script>
    // Menyimpan semua data transaksi (termasuk detail) ke dalam JS
    const allTransaksis = JSON.parse('{!! $allTransaksis !!}');

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }

    // Fungsi showDetailModal dihapus karena baris tabel sudah menampilkan detail item
    // Jika ada kebutuhan untuk menampilkan informasi kasir/toko, Anda bisa membuatnya di sini.

</script>