@extends('pos.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100 p-6">
    <div class="max-w-4xl mx-auto">
        
        {{-- HEADER --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pembayaran</h2>
                    <p class="text-sm text-gray-600">Transaksi #{{ $transaksi->id }}</p>
                </div>
                <a href="{{ route('pos.menupesanan') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            
            {{-- DETAIL PESANAN --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">Detail Pesanan</h3>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pelanggan:</span>
                        <span class="font-semibold">{{ $transaksi->nama_pelanggan }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Waktu:</span>
                        <span class="font-semibold">{{ $transaksi->waktu_transaksi->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                {{-- ITEMS --}}
                <div class="border-t pt-4 max-h-64 overflow-y-auto">
                    @foreach($transaksi->detailTransaksis as $detail)
                    <div class="flex justify-between items-start mb-3 pb-3">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $detail->produk->nama_produk }}</p>
                            <p class="text-xs text-gray-500">{{ $detail->jumlah }} × Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        <span class="font-semibold text-blue-600">
                            Rp {{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach
                </div>

                {{-- TOTAL --}}
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">Pilih Metode Pembayaran</h3>

                {{-- TAB BUTTONS --}}
                <div class="flex gap-3 mb-6">
                    <button onclick="switchTab('cash')" 
                            id="btnCash"
                            class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all bg-blue-600 text-white shadow-md">
                        Cash
                    </button>
                    <button onclick="switchTab('qris')" 
                            id="btnQris"
                            class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all bg-gray-200 text-gray-700 hover:bg-gray-300">
                        QRIS
                    </button>
                </div>

                {{-- CASH FORM --}}
                <div id="cashForm" class="payment-form">
                    <form action="{{ route('pos.bayar.cash', $transaksi->id) }}" method="POST" onsubmit="return validateCash()">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Uang Diterima
                            </label>
                            <input type="number" 
                                   id="uangDiterima"
                                   name="uang_diterima" 
                                   placeholder="Masukkan jumlah uang"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                                   required
                                   min="0"
                                   step="1000"
                                   oninput="hitungKembalian()">
                        </div>

                        {{-- QUICK AMOUNT BUTTONS --}}
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @php
                                $nominal = [
                                    ['label' => 'Pas', 'value' => $transaksi->total_harga],
                                    ['label' => '50K', 'value' => 50000],
                                    ['label' => '100K', 'value' => 100000],
                                ];
                            @endphp
                            @foreach($nominal as $n)
                            <button type="button" 
                                    onclick="setUang({{ $n['value'] }})"
                                    class="py-2 px-3 bg-gray-100 hover:bg-blue-100 border border-gray-300 rounded-lg text-sm font-semibold transition">
                                {{ $n['label'] }}
                            </button>
                            @endforeach
                        </div>

                        {{-- KEMBALIAN DISPLAY --}}
                        <div id="kembalianDisplay" class="hidden mb-4 p-4 bg-green-50 border-2 border-green-500 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700">Kembalian:</span>
                                <span id="kembalianValue" class="text-xl font-bold text-green-600"></span>
                            </div>
                        </div>

                        {{-- ALERT KURANG --}}
                        <div id="alertKurang" class="hidden mb-4 p-3 bg-red-50 border border-red-300 rounded-lg text-red-700 text-sm">
                            Uang yang diterima kurang dari total pembayaran!
                        </div>

                        <button type="submit" 
                                id="btnBayarCash"
                                class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Proses Pembayaran Cash
                        </button>
                    </form>
                </div>

                {{-- QRIS FORM --}}
                <div id="qrisForm" class="payment-form hidden">
                    <div class="text-center mb-6">
                        {{-- QR CODE --}}
                        <div class="inline-block p-4 bg-white border-4 border-gray-300 rounded-xl">
                            @if($transaksi->toko->qr_image)
                            <img src="{{ asset('storage/' . $transaksi->toko->qr_image) }}" 
                                 alt="QR Code" 
                                 class="w-48 h-48 mx-auto"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%239ca3af%22 font-size=%2218%22%3EQR Code Toko%3C/text%3E%3C/svg%3E'">
                            @else
                            <div class="w-48 h-48 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500 text-sm">QR Code Toko</span>
                            </div>
                            @endif
                        </div>
                        <p class="mt-4 text-sm text-gray-600">Scan QR Code untuk membayar</p>
                        <p class="text-lg font-bold text-blue-600 mt-2">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- FORM QRIS DENGAN ID --}}
                    <form id="formQris" action="{{ route('pos.bayar.qris', $transaksi->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-300 rounded-lg text-sm text-yellow-800">
                            Pastikan pembayaran sudah masuk sebelum konfirmasi
                        </div>

                        <button type="button" 
                                onclick="konfirmasiQris()"
                                class="w-full py-3 bg-green-600 text-white font-bold rounded-lg shadow-md hover:bg-green-700 transition-all active:scale-[0.98]">
                            Konfirmasi Pembayaran QRIS
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    const totalHarga = {{ $transaksi->total_harga }};

    // SWITCH TAB
    function switchTab(tab) {
        const cashForm = document.getElementById('cashForm');
        const qrisForm = document.getElementById('qrisForm');
        const btnCash = document.getElementById('btnCash');
        const btnQris = document.getElementById('btnQris');

        if (tab === 'cash') {
            cashForm.classList.remove('hidden');
            qrisForm.classList.add('hidden');
            btnCash.className = 'flex-1 py-3 px-4 rounded-lg font-semibold transition-all bg-blue-600 text-white shadow-md';
            btnQris.className = 'flex-1 py-3 px-4 rounded-lg font-semibold transition-all bg-gray-200 text-gray-700 hover:bg-gray-300';
        } else {
            cashForm.classList.add('hidden');
            qrisForm.classList.remove('hidden');
            btnCash.className = 'flex-1 py-3 px-4 rounded-lg font-semibold transition-all bg-gray-200 text-gray-700 hover:bg-gray-300';
            btnQris.className = 'flex-1 py-3 px-4 rounded-lg font-semibold transition-all bg-green-600 text-white shadow-md';
        }
    }

    // SET NOMINAL CEPAT
    function setUang(nominal) {
        document.getElementById('uangDiterima').value = nominal;
        hitungKembalian();
    }

    // HITUNG KEMBALIAN
    function hitungKembalian() {
        const uangDiterima = parseInt(document.getElementById('uangDiterima').value) || 0;
        const kembalian = uangDiterima - totalHarga;
        
        const kembalianDisplay = document.getElementById('kembalianDisplay');
        const kembalianValue = document.getElementById('kembalianValue');
        const alertKurang = document.getElementById('alertKurang');
        const btnBayarCash = document.getElementById('btnBayarCash');

        if (uangDiterima >= totalHarga && uangDiterima > 0) {
            // CUKUP
            kembalianDisplay.classList.remove('hidden');
            alertKurang.classList.add('hidden');
            kembalianValue.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
            btnBayarCash.disabled = false;
        } else if (uangDiterima > 0 && uangDiterima < totalHarga) {
            // KURANG
            kembalianDisplay.classList.add('hidden');
            alertKurang.classList.remove('hidden');
            btnBayarCash.disabled = true;
        } else {
            // KOSONG
            kembalianDisplay.classList.add('hidden');
            alertKurang.classList.add('hidden');
            btnBayarCash.disabled = true;
        }
    }

    // VALIDASI SEBELUM SUBMIT CASH
    function validateCash() {
        const uangDiterima = parseInt(document.getElementById('uangDiterima').value) || 0;
        
        if (uangDiterima < totalHarga) {
            Swal.fire({
                icon: 'error',
                title: 'Uang Tidak Cukup!',
                text: 'Jumlah uang yang diterima kurang dari total pembayaran',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
        return true;
    }

    // KONFIRMASI QRIS DENGAN SWEETALERT
    function konfirmasiQris() {
        Swal.fire({
            title: 'Konfirmasi Pembayaran QRIS',
            html: `
                <div class="text-center">
                    <div class="mb-4">
                        <svg class="mx-auto w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold mb-2">Total Pembayaran</p>
                    <p class="text-3xl font-bold text-green-600 mb-4">Rp ${totalHarga.toLocaleString('id-ID')}</p>
                    <p class="text-sm text-gray-600">Apakah pembayaran QRIS sudah diterima?</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-check mr-2"></i> Ya, Sudah Diterima',
            cancelButtonText: '<i class="fas fa-times mr-2"></i> Belum',
            reverseButtons: true,
            customClass: {
                confirmButton: 'px-6 py-3 rounded-lg font-bold',
                cancelButton: 'px-6 py-3 rounded-lg font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // LOADING
                Swal.fire({
                    title: 'Memproses Pembayaran...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // SUBMIT FORM
                document.getElementById('formQris').submit();
            }
        });
    }

    // ALERT JIKA ADA ERROR/SUCCESS DARI BACKEND
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#3085d6'
        });
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            // AUTO REDIRECT KE STRUK SETELAH SUCCESS
            window.location.href = '{{ route("pos.strukpesanan", $transaksi->id) }}';
        });
    @endif
</script>

@endsection