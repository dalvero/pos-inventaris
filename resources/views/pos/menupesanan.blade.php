@extends('pos.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-6 flex gap-6 relative z-10">

    <div class="w-3/4">

        {{-- HEADER --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Ayo Atur Pesananmu</h2>
                <p class="text-sm font-semibold text-gray-600">
                    Pilih menu sesuai pesanan.
                </p>
            </div>

            <a href="{{ route('dashboard') }}">
                <button
                    class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold shadow hover:bg-red-700 transition">
                    Closing
                </button>
            </a>
        </div>

        {{-- SEARCH --}}
        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama produk"
               class="w-full mb-4 px-4 py-2 rounded-lg border border-gray-300 shadow-sm">

        {{-- LIST PRODUK --}}
        <div id="produkList" class="grid grid-cols-3 gap-5">

            @forelse ($produk as $p)
                @php
                    // 1. Hitung Batas Maksimum Stok
                    $maxQty = INF;
                    foreach ($p->resepProduks as $resep) {
                        $stok_saat_ini = $resep->bahan->stok ?? 0;
                        $jumlah_dibutuhkan = $resep->jumlah;
                        
                        // Cek pembagian, hindari pembagian nol
                        if ($jumlah_dibutuhkan > 0) {
                            $possibleQty = floor($stok_saat_ini / $jumlah_dibutuhkan);
                            // Batas maksimum adalah nilai terkecil dari semua bahan
                            if ($possibleQty < $maxQty) {
                                $maxQty = $possibleQty;
                            }
                        } else {
                            // Jika resep tidak butuh bahan (jumlah = 0), kita abaikan pengecekan ini
                            // atau set maxQty = 0 jika stok 0
                            if ($stok_saat_ini == 0) {
                                $maxQty = 0;
                            }
                        }
                    }
                    
                    // Jika maxQty adalah INF (tidak ada resep/semua jumlah 0)
                    if ($maxQty == INF) $maxQty = 1000; // Default besar jika tidak ada resep

                    $isAvailable = $maxQty > 0;
                    $cardClass = $isAvailable ? '' : 'opacity-60 pointer-events-none';
                @endphp

                <div class="bg-white rounded-xl shadow p-3 produk-card relative {{ $cardClass }}" 
                      data-id="{{ $p->id }}" {{-- Tambahkan data-id untuk JS --}}
                      data-name="{{ strtolower($p->nama_produk) }}"
                      data-max-qty="{{ $maxQty }}" {{-- Menyimpan batas stok maksimum --}}
                      data-harga="{{ $p->harga }}">

                    {{-- GAMBAR PRODUK --}}
                    <img src="{{ asset('storage/' . $p->foto) }}"
                          class="w-full h-40 object-cover rounded-lg">

                    {{-- NAMA --}}
                    <h3 class="mt-3 font-bold text-gray-900">{{ $p->nama_produk }}</h3>

                    {{-- HARGA --}}
                    <p class="text-sm text-gray-600">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </p>

                    {{-- TOMBOL - dan + --}}
                    <div class="flex gap-2 mt-3">

                        {{-- TOMBOL KURANGI --}}
                        <button onclick="removeFromCart({{ $p->id }})"
                            class="w-1/2 bg-red-500 text-white py-2 rounded-lg font-semibold hover:bg-red-600">
                            -
                        </button>

                        {{-- TOMBOL TAMBAH --}}
                        @if ($isAvailable)
                            {{-- Panggil JS dengan ID saja, karena data sudah ada di attribute card --}}
                            <button onclick="addToCart({{ $p->id }})"
                                class="w-1/2 bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                                +
                            </button>
                        @else
                            {{-- TAMPILAN JIKA STOK KURANG (Tombol dinonaktifkan) --}}
                            <button disabled title="Stok bahan baku tidak mencukupi."
                                class="w-1/2 bg-gray-400 text-white py-2 rounded-lg font-semibold cursor-not-allowed relative">
                                STOK KOSONG
                            </button>
                        @endif

                    </div>
                    
                    {{-- Badge Status Stok --}}
                    @if (!$isAvailable)
                        <div class="absolute top-0 right-0 mt-2 mr-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg transform rotate-3">
                            HABIS
                        </div>
                    @else
                        {{-- Tampilkan batas stok di sini --}}
                        <div class="absolute top-0 right-0 mt-2 mr-2 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg transform rotate-3"
                             title="Maksimum order berdasarkan stok bahan baku">
                            Stok: {{ $maxQty }}
                        </div>
                    @endif

                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Belum ada produk.</p>
            @endforelse
        </div>
    </div>


    {{-- BAGIAN KERANJANG --}}
    <div class="w-1/4 bg-white rounded-xl shadow p-4">

        <h3 class="text-lg font-bold mb-2">Keranjang</h3>

        <div id="cartItems" class="border-b pb-2 mb-2 text-gray-700">
            <p class="text-gray-500">Belum ada item.</p>
        </div>

        {{-- TOTAL --}}
        <div class="flex justify-between font-bold text-gray-800 text-lg mb-4">
            <span>Total:</span>
            <span id="cartTotal">Rp 0</span>
        </div>

        {{-- NAMA CUSTOMER --}}
        <input type="text" id="customerName" placeholder="Masukkan nama pelanggan"
        class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm">

        {{-- TOMBOL PESAN --}}
        <button id="checkoutButton" onclick="processOrder()" class="w-full py-3 bg-linear-to-tr from-blue-600 to-blue-400 text-white font-bold rounded-lg shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 transition-all active:scale-[0.98]">
            Pesan Sekarang
        </button>

        {{-- HAPUS KERANJANG --}}
        <button onclick="clearCart()" 
             class="w-full mt-2 border border-gray-400 py-2 rounded-lg text-gray-700">
            Kosongkan Keranjang
        </button>

        {{-- Loading Overlay --}}
        <div id="loadingOverlay" class="hidden absolute inset-0 bg-white/70 backdrop-blur-sm rounded-xl flex items-center justify-center">
            <div class="flex flex-col items-center">
                <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-blue-600 font-semibold">Memproses Pesanan...</p>
            </div>
        </div>
    </div>
</div>

{{-- =======================================
    SCRIPT JS LOGIKA KERANJANG
======================================= --}}
<script>
    // Konfigurasi CSRF Token Laravel
    const CSRF_TOKEN = "{{ csrf_token() }}";
    let cart = [];
    const checkoutButton = document.getElementById('checkoutButton');
    const loadingOverlay = document.getElementById('loadingOverlay');

    function showAlert(title, message, icon = "warning") {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            confirmButtonColor: "#3085d6",
        });
    }

    function getProductCard(id) {
        return document.querySelector(`.produk-card[data-id="${id}"]`);
    }

    // Tambah ke keranjang
    function addToCart(id) {
        const card = getProductCard(id);
        if (!card) return;

        const maxQty = parseInt(card.dataset.maxQty, 10);
        const nama = card.querySelector('h3').textContent.trim();
        const harga = parseInt(card.dataset.harga, 10);

        let item = cart.find(i => i.id === id);

        if (item) {
            // Cek batas maksimum
            if (item.qty < maxQty) {
                item.qty++;
            } else {
                showAlert("Stok Habis!", `Maaf, stok maksimum untuk ${nama} hanya ${maxQty} item.`, "error");
                return;
            } 
        } else {
            if (maxQty > 0) {
                cart.push({ id, nama, harga, qty: 1, maxQty: maxQty });
            } else {
                 Swal.fire({
                    title: 'Stok Habis!',
                    text: `Maaf, stok bahan baku untuk ${nama} habis.`,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                 return;
            }
        }

        renderCart();
    }


    // Kurangi keranjang
    function removeFromCart(id) {
        let item = cart.find(i => i.id === id);
        if (!item) return;

        item.qty--;

        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }

        renderCart();
    }

    // Render isi keranjang
    function renderCart() {
        let container = document.getElementById('cartItems');
        container.innerHTML = "";

        if (cart.length === 0) {
            container.innerHTML = "<p class='text-gray-500'>Belum ada item.</p>";
            checkoutButton.disabled = true;
        } else {
             checkoutButton.disabled = false;
        }

        let total = 0;

        cart.forEach(item => {
            let subtotal = item.qty * item.harga;
            total += subtotal;

            container.innerHTML += `
                <div class="flex justify-between mb-2 items-center">
                    <div class="w-3/4">
                        <span class="font-medium text-sm">${item.nama}</span>
                        <p class="text-xs text-gray-500">${item.qty} x Rp ${item.harga.toLocaleString('id-ID')}</p>
                    </div>
                    <span class="w-1/4 text-right text-sm font-semibold">Rp ${subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;
        });

        document.getElementById('cartTotal').textContent =
            "Rp " + total.toLocaleString('id-ID');
    }

    // Hapus semua
    function clearCart() {
        cart = [];
        renderCart();
    }

    async function processOrder() {
        if (cart.length === 0) {
            Swal.fire({ title: "Perhatian", text: "Keranjang masih kosong. Silakan pilih menu terlebih dahulu.", icon: "warning" });
            return;
        }

        const customerName = document.getElementById('customerName').value.trim() || 'Umum';
        const totalAmount = cart.reduce((sum, item) => sum + (item.qty * item.harga), 0);

        const cartItems = cart.map(item => ({
            produk_id: item.id,
            quantity: item.qty,
            harga_satuan: item.harga
        }));

        const payload = {
            _token: CSRF_TOKEN,
            total_amount: totalAmount,
            customer_name: customerName,
            cart_items: cartItems
        };

        // tampilkan loading overlay (jika ada)
        if (loadingOverlay) loadingOverlay.classList.remove('hidden');

        try {
            const response = await fetch("{{ route('pos.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json' // minta JSON agar Laravel bisa mengembalikan JSON pada error validasi
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                let errorData;
                
                // Coba parse sebagai JSON
                try {
                    errorData = await response.json();
                } catch (e) {
                    // Jika gagal parse JSON (mungkin HTML error 500)
                    const text = await response.text();
                    Swal.fire({
                        title: `Error ${response.status}`,
                        html: `<p>Gagal parsing respons server. Cek log server.</p><pre style="white-space:pre-wrap; max-height: 200px; overflow-y: scroll;">${escapeHtml(text.substring(0, 500))}...</pre>`, 
                         icon: 'error'
                         });
                          return;
                }
                
                let errorMessage = 'Terjadi kesalahan saat memproses pesanan.';

                 // 1. Penanganan Validasi Stok (Controller custom: status 400)
                 if (response.status === 400 && errorData.message) {
                    errorMessage = errorData.message;
                    Swal.fire({ title: 'Stok Bahan Baku Tidak Cukup!', text: errorMessage, icon: 'error' });
                    return;
                } 
                
                // 2. Penanganan Validasi Form Laravel (status 422)
                else if (response.status === 422 && errorData.errors) {
                    let errorList = Object.values(errorData.errors).flat().join('<br>');
                    Swal.fire({ title: 'Data Tidak Valid', html: errorList, icon: 'warning' });
                    return;
                }
                
                // 3. Penanganan Error Umum Lain (401, 403, 500)
                else {
                    errorMessage = errorData.message || errorMessage;
                    Swal.fire({ title: `Error ${response.status}`, text: errorMessage, icon: 'error' });
                    return;
                }
            }
            
// ...

            // kalau 2xx, parse JSON
            const result = await response.json();

            if (result.success) {
                // redirect ke detail pesanan
                window.location.href = `/detail-pesanan/${result.transaksi_id}`;
            } else {
                Swal.fire({ title: 'Transaksi Gagal', text: result.message || 'Terjadi masalah', icon: 'error' });
            }

        } catch (err) {
            console.error('Fetch error:', err);
            // Tampilkan pesan lebih informatif
            Swal.fire({
                title: 'Error Jaringan',
                text: 'Terjadi masalah koneksi atau server (cek console / network tab).',
                icon: 'error'
            });
        } finally {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
        }
    }

    // helper kecil untuk escape HTML agar safe saat menampilkan response HTML
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    
    // Inisialisasi awal
    document.addEventListener('DOMContentLoaded', renderCart); 

    // SEARCH
    document.getElementById("searchInput").addEventListener("input", function () {
        let q = this.value.toLowerCase();
        document.querySelectorAll(".produk-card").forEach(card => {
            let name = card.dataset.name;
            card.style.display = name.includes(q) ? "block" : "none";
        });
    });
</script>

@endsection