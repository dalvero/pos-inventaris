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

                {{-- WAKTU REAL TIME --}}
                <p id="realTimeClock" class="text-sm font-semibold text-gray-700"></p>
            </div>

            <form action="{{ route('kasir.closing') }}" method="POST">
                @csrf
                <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold shadow hover:bg-red-700 transition">
                    Closing
                </button>
            </form>
        </div>



        {{-- SEARCH --}}
        <input type="text" id="searchInput" placeholder="Cari berdasarkan nama produk"
               class="w-full mb-4 px-4 py-2 rounded-lg border border-gray-300 shadow-sm">

        {{-- LIST PRODUK --}}
        <div id="produkList" class="grid grid-cols-3 gap-5">

            @forelse ($produk as $p)
                @php
                    // HITUNG maxQty DARI RESEP
                    $maxQty = INF;
                    foreach ($p->resepProduks as $resep) {
                        $stok_saat_ini = $resep->bahan->stok ?? 0;
                        $jumlah_dibutuhkan = $resep->jumlah;
                        
                        if ($jumlah_dibutuhkan > 0) {
                            $possibleQty = floor($stok_saat_ini / $jumlah_dibutuhkan);
                            if ($possibleQty < $maxQty) {
                                $maxQty = $possibleQty;
                            }
                        } else {
                            if ($stok_saat_ini == 0) {
                                $maxQty = 0;
                            }
                        }
                    }
                    
                    if ($maxQty == INF || $maxQty < 0) $maxQty = 0;
                    $isAvailable = $maxQty > 0;
                @endphp

                <div class="bg-white rounded-xl shadow p-3 produk-card relative transition-opacity duration-200" 
                      data-id="{{ $p->id }}"
                      data-name="{{ strtolower($p->nama_produk) }}"
                      data-max-qty="{{ $maxQty }}"
                      data-harga="{{ $p->harga }}"
                      data-bahan='@json($p->resepProduks->map(function($r){
                            return [
                                "id"=>$r->bahan_id,
                                "jumlah"=>$r->jumlah,
                                "stok"=>$r->bahan->stok ?? 0
                            ];
                        }))'>

                    {{-- BADGE STOK (dinamis via JS) --}}
                    <div class="badge-stok absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded-full text-white shadow-lg">
                        <!-- Diisi oleh JS -->
                    </div>

                    {{-- GAMBAR PRODUK --}}
                    <img src="{{ asset('storage/' . $p->foto) }}"
                          class="w-full h-40 object-cover rounded-lg">

                    {{-- NAMA --}}
                    <h3 class="mt-3 font-bold text-gray-900">{{ $p->nama_produk }}</h3>

                    {{-- HARGA --}}
                    <p class="text-sm text-gray-600">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </p>

                    {{-- TOMBOL - DAN + --}}
                    <div class="flex gap-2 mt-3">

                        {{-- TOMBOL KURANGI --}}
                        <button onclick="removeFromCart({{ $p->id }})"
                            class="cursor-pointer btn-minus w-1/2 bg-red-500 text-white py-2 rounded-lg font-semibold hover:bg-red-600 transition-all">
                            -
                        </button>

                        {{-- TOMBOL TAMBAH --}}
                        <button onclick="addToCart({{ $p->id }})"
                            class="cursor-pointer btn-add w-1/2 bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all disabled:bg-gray-400 disabled:cursor-not-allowed">
                            +
                        </button>

                    </div>

                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Belum ada produk.</p>
            @endforelse
        </div>
    </div>


    {{-- BAGIAN KERANJANG --}}
    <div class="w-1/4 bg-white rounded-xl shadow p-4 relative">

        <h3 class="text-lg font-bold mb-2">Keranjang</h3>

        <div id="cartItems" class="pb-2 mb-2 text-gray-700 max-h-96 overflow-y-auto">
            <p class="text-gray-500">Belum ada item.</p>
        </div>

        {{-- TOTAL --}}
        <div class="flex justify-between font-bold text-gray-800 text-lg mb-4">
            <span>Total:</span>
            <span id="cartTotal">Rp 0</span>
        </div>

        {{-- NAMA CUSTOMER --}}
        <input type="text" id="customerName" placeholder="Masukkan nama pelanggan"
        class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">

        {{-- TOMBOL PESAN --}}
        <button id="checkoutButton" onclick="processOrder()" 
            class="w-full py-3 bg-linear-to-r from-blue-600 to-blue-400 text-white font-bold rounded-lg shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
            Pesan Sekarang
        </button>

        {{-- HAPUS KERANJANG --}}
        <button onclick="clearCart()" 
             class="w-full mt-2 border border-gray-400 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-all">
            Kosongkan Keranjang
        </button>

        {{-- LOADING PESANAN --}}
        <div id="loadingOverlay" class="hidden absolute inset-0 bg-white/70 backdrop-blur-sm rounded-xl items-center justify-center z-50">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-blue-600 font-semibold">Memproses Pesanan...</p>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT LOGIKA STOK PRODUK, STOK BAHAN DAN PEMESANAN --}}
<script>
    const CSRF_TOKEN = "{{ csrf_token() }}";
    let cart = [];
    let bahanStokVirtual = {}; // STOK VIRTUAL BAHAN

    const checkoutButton = document.getElementById('checkoutButton');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // INISIALISASI
    function initStokVirtual() {
        // AMBIL STOK AWAL DARI SETIAP CARD
        bahanStokVirtual = {};
        document.querySelectorAll('.produk-card').forEach(card => {
            const bahanList = JSON.parse(card.dataset.bahan);
            bahanList.forEach(b => {
                if (!(b.id in bahanStokVirtual)) {
                    bahanStokVirtual[b.id] = b.stok;
                }
            });
        });
    }

    // HELPER FUNCTIONS
    function showAlert(title, message, icon = "warning") {
        Swal.fire({ 
            title, 
            text: message, 
            icon, 
            confirmButtonColor: "#3085d6"
        });
    }

    function getProductCard(id) {
        return document.querySelector(`.produk-card[data-id="${id}"]`);
    }

    // UPDATE BADGE & TOMBOL
    function updateCardUI(card) {
        // HITUNG maxQty BERDASARKAN STOK VIRTUAL 
        const bahanList = JSON.parse(card.dataset.bahan);
        let maxQty = Infinity;

        bahanList.forEach(b => {
            const stokVirtual = bahanStokVirtual[b.id] ?? 0;
            if (b.jumlah > 0) {
                const possible = Math.floor(stokVirtual / b.jumlah);
                if (possible < maxQty) maxQty = possible;
            }
        });

        if (maxQty === Infinity) maxQty = 1000;
        if (maxQty < 0) maxQty = 0;
        
        card.dataset.maxQty = maxQty;

        // UPDATE BADGE
        const badge = card.querySelector('.badge-stok');
        const threshold = 5;

        if (maxQty === 0) {
            badge.textContent = 'HABIS';
            badge.className = 'badge-stok absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded-full text-white shadow-lg bg-red-600';
            card.style.opacity = '0.6';
        } else if (maxQty <= threshold) {
            badge.textContent = `MENIPIS\nStok: ${maxQty}`;
            badge.className = 'badge-stok absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded-full text-white shadow-lg bg-yellow-500';
            card.style.opacity = '1';
        } else {
            badge.textContent = `Stok: ${maxQty}`;
            badge.className = 'badge-stok absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded-full text-white shadow-lg bg-green-600';
            card.style.opacity = '1';
        }

        // UPDATE TOMBOL (HANYA DISABLE JIKA BENAR-BENAR HABIS)
        const btnAdd = card.querySelector('.btn-add');
        if (maxQty <= 0) {
            btnAdd.disabled = true;
            btnAdd.textContent = 'HABIS';
        } else {
            btnAdd.disabled = false;
            btnAdd.textContent = '+';
        }
    }

    function updateAllCards() {
        // UPDATE SEMUA CARD
        document.querySelectorAll('.produk-card').forEach(card => {
            updateCardUI(card);
        });
    }

    // TAMBAH KE KERANJANG 
    function addToCart(id) {
        const card = getProductCard(id);
        if (!card) return;

        const bahanList = JSON.parse(card.dataset.bahan);
        let item = cart.find(i => i.id === id);

        // CEK STOK VIRTUAL TERSEDIA
        let canAdd = true;
        bahanList.forEach(b => {
            const stokVirtual = bahanStokVirtual[b.id] ?? 0;
            if (stokVirtual < b.jumlah) {
                canAdd = false;
            }
        });

        if (!canAdd) {
            return showAlert("Stok Habis!", "Bahan baku tidak mencukupi", "error");
        }

        if (item) {
            // TAMBAH qty EXISTING ITEM
            item.qty++;
        } else {
            // TAMBAH ITEM BARU
            const nama = card.querySelector('h3').textContent.trim();
            const harga = parseInt(card.dataset.harga, 10);
            cart.push({ id, nama, harga, qty: 1 });
        }

        // KURANGI STOK VIRTUAL
        bahanList.forEach(b => {
            bahanStokVirtual[b.id] -= b.jumlah;
        });

        updateAllCards();
        renderCart();
    }

    // KURANGI DARI KERANJANG 
    function removeFromCart(id) {
        let item = cart.find(i => i.id === id);
        if (!item) return;

        const card = getProductCard(id);
        const bahanList = JSON.parse(card.dataset.bahan);

        // KEMBALIKAN STOK VIRTUAL
        bahanList.forEach(b => {
            bahanStokVirtual[b.id] += b.jumlah;
        });

        item.qty--;
        
        // HAPUS JIKA qty 0
        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }

        updateAllCards();
        renderCart();
    }

    // RENDER KERANJANG
    function renderCart() {
        const container = document.getElementById('cartItems');
        container.innerHTML = "";

        // CEK KERANJANG KOSONG
        if (cart.length === 0) {
            container.innerHTML = "<p class='text-gray-500 text-center py-4'>Belum ada item.</p>";
            checkoutButton.disabled = true;
            document.getElementById('cartTotal').textContent = "Rp 0";
            return;
        }

        checkoutButton.disabled = false;
        let total = 0;

        // TAMPILKAN ITEMS
        cart.forEach(item => {
            const subtotal = item.qty * item.harga;
            total += subtotal;
            
            container.innerHTML += `
                <div class="flex justify-between mb-3 items-start border-b pb-2">
                    <div class="w-2/3">
                        <span class="font-medium text-sm block">${item.nama}</span>
                        <p class="text-xs text-gray-500">${item.qty} × Rp ${item.harga.toLocaleString('id-ID')}</p>
                    </div>
                    <span class="w-1/3 text-right text-sm font-semibold text-blue-600">
                        Rp ${subtotal.toLocaleString('id-ID')}
                    </span>
                </div>
            `;
        });

        document.getElementById('cartTotal').textContent = "Rp " + total.toLocaleString('id-ID');
    }

    // KOSONGKAN KERANJANG
    function clearCart() {
        if (cart.length === 0) return;

        // KEMBALIKAN SEMUA STOK
        cart.forEach(item => {
            const card = getProductCard(item.id);
            const bahanList = JSON.parse(card.dataset.bahan);
            
            bahanList.forEach(b => {
                bahanStokVirtual[b.id] += b.jumlah * item.qty;
            });
        });

        cart = [];
        updateAllCards();
        renderCart();
    }

    // PROSES PESANAN
    async function processOrder() {
        // VALIDASI KERANJANG
        if (cart.length === 0) {
            return showAlert("Keranjang Kosong!", "Pilih menu terlebih dahulu", "warning");
        }

        const customerName = document.getElementById('customerName').value.trim() || 'Umum';
        const totalAmount = cart.reduce((sum, i) => sum + (i.qty * i.harga), 0);
        const cartItems = cart.map(i => ({
            produk_id: i.id,
            quantity: i.qty,
            harga_satuan: i.harga
        }));

        const payload = {
            _token: CSRF_TOKEN,
            total_amount: totalAmount,
            customer_name: customerName,
            cart_items: cartItems
        };

        // TAMPILKAN LOADING
        if (loadingOverlay) loadingOverlay.classList.remove('hidden');
        checkoutButton.disabled = true;

        try {
            const response = await fetch("{{ route('pos.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            // HANDLE ERROR
            if (!response.ok) {
                const msg = result.message || "Terjadi kesalahan saat memproses pesanan";
                return showAlert("Error", msg, "error");
            }

            // REDIRECT KE DETAIL
            if (result.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pesanan berhasil diproses',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = `/pembayaran/${result.transaksi_id}`;
                });
            }
        } catch (err) {
            console.error('Error:', err);
            showAlert("Error", "Terjadi kesalahan jaringan atau server", "error");
        } finally {
            // SEMBUNYIKAN LOADING
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
            checkoutButton.disabled = false;
        }
    }

    // SEARCH PRODUK
    document.getElementById("searchInput").addEventListener("input", function () {
        const query = this.value.toLowerCase();
        
        document.querySelectorAll(".produk-card").forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(query) ? "block" : "none";
        });
    });

    // INIT ON LOAD
    document.addEventListener('DOMContentLoaded', () => {
        // INISIALISASI APLIKASI
        initStokVirtual();
        updateAllCards();
        renderCart();
    });
</script>

{{-- SCRIPT TIMER --}}
<script>
    function updateClock() {
        const now = new Date();

        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };

        const formatted = now.toLocaleTimeString('id-ID', options);
        document.getElementById('realTimeClock').textContent = formatted;
    }

    // UPDATE PERTAMA
    updateClock();

    // UPDATE SETIAP 1 DETIK
    setInterval(updateClock, 1000);
</script>
@endsection