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
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[6%]">
                            <p class="text-sm text-center font-semibold text-gray-900">No</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[22%]">
                            <p class="text-sm font-semibold text-gray-900">Pesanan (Nama Produk)</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[14%]">
                            <p class="text-sm text-center font-semibold text-gray-900">Kode Transaksi</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[10%]">
                            <p class="text-sm text-center font-semibold text-gray-900">Jumlah</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[15%]">
                            <p class="text-sm text-right font-semibold text-gray-900">Harga Satuan</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[15%]">
                            <p class="text-sm text-right font-semibold text-gray-900">Total Harga</p>
                        </th>
                        <th class="border-b border-gray-200 bg-gray-50 p-4 w-[18%]">
                            <p class="text-sm font-semibold text-gray-900">Waktu Transaksi</p>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @php 
                        $globalIndex = ($transaksis->currentPage() - 1) * $transaksis->perPage(); 
                    @endphp

                    @forelse($transaksis as $transaksi)
                        @foreach($transaksi->detailTransaksis as $detail)
                            @php 
                                $globalIndex++;                                
                                $hargaSatuan = $detail->harga_satuan ?? ($detail->subtotal / $detail->jumlah);
                                $totalHargaItem = $detail->subtotal ?? ($hargaSatuan * $detail->jumlah);
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="p-4 border-b border-gray-200 text-center">
                                    <p class="text-sm text-gray-900">{{ $globalIndex }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}
                                    </p>
                                    <p class="text-xs text-gray-500">Struk ID: #{{ $transaksi->id }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-center">
                                    <p class="text-sm text-gray-900">{{ $transaksi->kode_transaksi }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-center">
                                    <p class="text-sm text-gray-900">{{ $detail->jumlah }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-right">
                                    <p class="text-sm text-gray-900">
                                        Rp{{ number_format($hargaSatuan, 0, ',', '.') }},00
                                    </p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-right font-bold text-green-600">
                                    Rp{{ number_format($totalHargaItem, 0, ',', '.') }},00
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d M Y, H:i:s') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">
                                Belum ada data transaksi hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- PAGINATION --}}        
        <div class="p-6 border-t border-gray-200">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection

<script>
    // MENYIMPAN SEMUA DATA TRANSAKSI KE DALAM JS
    const allTransaksis = JSON.parse('{!! $allTransaksis !!}');

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }
</script>