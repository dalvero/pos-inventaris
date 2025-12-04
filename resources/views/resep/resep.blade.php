@extends('produk.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="mt-6 mr-4">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Resep Produk</h2>
            <p class="text-sm font-semibold text-gray-600">Resep Produk di {{ Auth::user()->toko->nama_toko }}.</p>
        </div>
    </div>
    
    {{-- GRID PRODUK YANG SUDAH PUNYA RESEP --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

        {{-- CARD TAMBAH PRODUK --}}
        <div onclick="openResepModal('create')"
             class="flex bg-white rounded-xl shadow-md hover:shadow-lg transition cursor-pointer group">
            <div class="w-32 h-full bg-orange-50 flex items-center justify-center rounded-l-xl group-hover:bg-orange-100 transition">
                <div class="w-20 h-20 flex items-center justify-center bg-white rounded-full shadow group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-10 h-10 text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
            </div>

            <div class="flex-1 p-4 flex flex-col justify-center">
                <h3 class="font-bold text-gray-900 text-lg">Tambah Resep</h3>
                <p class="text-sm text-gray-500">Tambahkan resep untuk produk-produk di {{Auth::user()->toko->nama_toko}}.</p>
            </div>
        </div>

        {{-- LIST PRODUK DENGAN RESEP --}}
        @forelse ($produks as $produk)
            <div class="flex cursor-pointer bg-white rounded-xl shadow-md hover:shadow-lg transition">
                <img
                    class="object-cover w-32 h-full rounded-l-xl"
                    src="{{ $produk->foto ? asset('storage/'.$produk->foto) : asset('storage/img/no_image.jpg') }}"
                    alt="{{ $produk->nama_produk }}"
                >

                <div class="flex-1 p-4">

                    {{-- NAMA PRODUK --}}
                    <h3 class="font-bold text-gray-900 text-lg">
                        {{ $produk->nama_produk }}
                    </h3>

                    {{-- DESKRIPSI SINGKAT --}}
                    <p class="text-sm text-gray-500 mb-3">
                        Kelola resep {{ strtolower($produk->nama_produk) }}
                    </p>

                    {{-- ACTION BUTTONS --}}
                    <div class="flex items-center gap-3">

                        {{-- DETAIL RESEP --}}
                        <button onclick="openDetailResep({{ $produk->id }})"
                            class="p-2 cursor-pointer rounded-lg bg-emerald-50 hover:bg-emerald-100 transition" title="Detail Resep">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-emerald-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>

                        {{-- EDIT RESEP --}}
                        <button onclick="openResepModal('editResep', { produk_id: {{ $produk->id }} })"
                            class="p-2 cursor-pointer rounded-lg bg-blue-50 hover:bg-blue-100 transition" title="Edit Resep">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-blue-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5l3 3L12 15H9v-3L18.5 2.5z" />
                            </svg>
                        </button>

                        {{-- DELETE RESEP --}}
                        <form action="{{ route('resep.destroy', $produk->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="p-2 cursor-pointer rounded-lg bg-red-50 hover:bg-red-100 transition btn-delete" title="Hapus Semua Resep Produk Ini">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-red-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4H9v3m-4 0h14" />
                                </svg>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-3 text-center py-6">Belum ada produk berisi resep.</p>
        @endforelse

    </div>
</div>

{{-- MODAL TAMBAH/EDIT RESEP --}}
<div id="resepModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        
        <div id="modalContent"
            class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 relative mx-4">

            <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Tambah Resep</h2>

            <form id="resepForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">

                {{-- PREVIEW FOTO PRODUK --}}
                <div id="previewContainer" class="mb-4 hidden">
                    <label class="block text-sm font-semibold mb-2 text-gray-700">Preview Foto Produk</label>
                    <div class="flex justify-center">
                        <img id="previewImage" src="" class="w-40 h-40 object-cover rounded-lg border-2 border-gray-200">
                    </div>
                </div>

                {{-- PRODUK --}}
                <div class="mb-4">
                    <label class="cursor-pointer block text-sm font-semibold mb-2 text-gray-700">Pilih Produk</label>
                    <select name="produk_id" id="inputProduk" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($semuaProduk as $p)
                            <option value="{{ $p->id }}" data-foto="{{ asset('storage/' . $p->foto) }}">
                                {{ $p->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- WRAPPER MULTI BAHAN --}}
                <div id="bahanWrapper"></div>

                <button type="button"
                    onclick="addBahanRow()"
                    class="cursor-pointer w-full py-2 mb-4 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    + Tambah Bahan
                </button>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeResepModal()"
                        class="cursor-pointer px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit"
                        class="cursor-pointer px-5 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const resepProduks = @json($reseps);
</script>


{{-- MODAL DETAIL RESEP --}}
<div id="detailResepModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm"
    onclick="closeDetailResep()">

    <div class="bg-white w-[420px] max-w-[90vw] rounded-2xl shadow-2xl overflow-hidden animate-fadeIn"
         onclick="event.stopPropagation()">

        <!-- HEADER -->
        <div class="text-center p-6 bg-linear-to-br from-orange-600 to-orange-700">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full mx-auto flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>

            <p id="detailNamaProduk" class="text-xl font-bold text-white"></p>
            <p class="text-sm text-emerald-100 mt-1">Detail Komposisi Resep</p>

            <div class="mt-4">
                <span class="inline-block border-2 border-white/50 rounded-full py-1.5 px-4 text-xs font-semibold text-white bg-white/20 backdrop-blur-sm">
                    <span id="detailJumlahBahan"></span> Bahan
                </span>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-5 max-h-[400px] overflow-y-auto">
            <div id="detailResepList" class="space-y-3">
                <!-- DATA RESEP TAMPIL DISINI -->
            </div>
            
            <!-- JIKA TIDAK ADA RESEP -->
            <div id="emptyResepMessage" class="hidden text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-300 mx-auto mb-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <p class="text-gray-500 text-sm">Tidak ada resep untuk produk ini.</p>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
            <button onclick="closeDetailResep()"
                    class="cursor-pointer px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold text-gray-700 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT MODAL --}}
<script>
    const bahanData = @json($bahans);
    const produksWithResep = @json($produks); 
    
    // BUKA MODAL TAMBAH/EDIT
    function openResepModal(mode, data = null) {
        const modal = document.getElementById("resepModal");
        modal.classList.remove("hidden");
        modal.classList.add("flex");

        document.getElementById("resepForm").reset();
        document.getElementById("previewContainer").classList.add("hidden");
        document.getElementById("bahanWrapper").innerHTML = "";

        const form = document.getElementById("resepForm");
        const methodField = document.getElementById("methodField");

        if (mode === 'create') {
            document.getElementById("modalTitle").textContent = "Tambah Resep";
            form.action = "{{ route('resep.store') }}";
            methodField.value = "POST";

            document.getElementById("inputProduk").disabled = false;
            document.getElementById("inputProduk").value = "";

            addBahanRow();

        } else if (mode === 'editResep') {
            document.getElementById("modalTitle").textContent = "Edit Resep";

            const produk = produksWithResep.find(p => p.id == data.produk_id);
            if (!produk) {
                console.error('Produk tidak ditemukan');
                return;
            }

            console.log('Produk yang dipilih:', produk); // DEBUG
            console.log('Resep produk:', produk.resep_produks); // DEBUG
            
            form.action = "/resep/" + produk.id;
            methodField.value = "PUT";

            let select = document.getElementById("inputProduk");
            select.value = produk.id;
            select.dispatchEvent(new Event('change'));
            select.disabled = true;
            
            if (produk.resep_produks && produk.resep_produks.length > 0) {
                produk.resep_produks.forEach(r => {
                    addBahanRow(r.bahan_id, r.jumlah);
                });
            } else {
                addBahanRow();
            }
        }
    }

    // TUTUP MODAL
    function closeResepModal() {
        const modal = document.getElementById("resepModal");
    
        // TAMBAH HIDDEN, HAPUS FLEX
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }

    // TAMBAH ROW BAHAN
    function addBahanRow(bahanId = "", jumlahValue = "") {
        let wrapper = document.getElementById("bahanWrapper");
        let html = `
            <div class="flex gap-2 mb-3 item-row">
                <select name="bahan_id[]" required class="flex-1 border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">-- Pilih Bahan --</option>
                    ${bahanData.map(b => `
                        <option value="${b.id}" ${bahanId == b.id ? "selected" : ""}>
                            ${b.nama_bahan} (Stok: ${b.stok} ${b.satuan})
                        </option>
                    `).join('')}
                </select>
                <input type="number" name="jumlah[]" required min="0" step="0.01" value="${jumlahValue}"
                    class="w-24 border border-gray-300 rounded-lg px-3 py-2" placeholder="Qty">
                <button type="button" onclick="this.parentElement.remove()"
                    class="cursor-pointer px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">X</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
    }

    // PREVIEW FOTO & UPDATE ACTION URL
    document.getElementById("inputProduk").addEventListener("change", function () {
        let selected = this.options[this.selectedIndex];
        let foto = selected.getAttribute("data-foto");

        if (foto && foto !== "") {
            document.getElementById("previewContainer").classList.remove("hidden");
            document.getElementById("previewImage").src = foto;
        } else {
            document.getElementById("previewContainer").classList.add("hidden");
        }
    });
</script>

{{-- SCRIPT OPEN/CLOSE MODAL DETAIL RESEP --}}
<script>
    function openDetailResep(produkId) {
        console.log('Opening detail for produk:', produkId);
        console.log('Available reseps:', resepProduks);
        
        // FILTER DATA RESEP BERDASARKAN PRODUK ID
        const resep = resepProduks.filter(r => r.produk_id == produkId);
        
        console.log('Filtered resep:', resep);

        // CARI NAMA PRODUK
        const produk = produksWithResep.find(p => p.id == produkId);
        const namaProduk = produk ? produk.nama_produk : 'Produk';
        
        // SET NAMA PRODUK DI HEADER
        document.getElementById('detailNamaProduk').textContent = namaProduk;
        document.getElementById('detailJumlahBahan').textContent = resep.length;

        // TARGET ELEMENT MODAL
        const container = document.getElementById('detailResepList');
        const emptyMessage = document.getElementById('emptyResepMessage');
        container.innerHTML = '';

        if (resep.length === 0) {
            container.classList.add('hidden');
            emptyMessage.classList.remove('hidden');
        } else {
            container.classList.remove('hidden');
            emptyMessage.classList.add('hidden');
            
            resep.forEach((item, index) => {
                // PASTIKAN BAHAN ADA
                const namaBahan = item.bahan ? item.bahan.nama_bahan : 'Bahan tidak ditemukan';
                const satuan = item.bahan ? item.bahan.satuan : '';
                
                // WARNA BERBEDA UNTUK SETIAP BAHAN
                const colors = ['blue', 'purple', 'pink', 'indigo', 'cyan'];
                const color = colors[index % colors.length];
                
                container.innerHTML += `
                    <div class="flex items-center gap-3 p-3 bg-${color}-50 rounded-lg">
                        <div class="w-10 h-10 bg-${color}-100 rounded-full flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-${color}-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">Bahan #${index + 1}</p>
                            <p class="font-semibold text-gray-800">${namaBahan}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-${color}-600">${item.jumlah}</p>
                            <p class="text-xs text-gray-500">${satuan}</p>
                        </div>
                    </div>
                `;
            });
        }

        // TAMPILKAN MODAL
        const modal = document.getElementById('detailResepModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDetailResep() {
        const modal = document.getElementById('detailResepModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

{{-- SCRIPT SWEET ALERT KONFIRMASI HAPUS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); 
                const form = this.closest('.delete-form');

                Swal.fire({
                    title: 'Hapus Bahan?',
                    text: "Bahan akan dihapus dari resep ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'   
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

{{-- SWEET ALERT SUCCESS --}}
@if(session('successTambahResep') || session('successHapusResep') || session('successEditResep'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('successTambahResep') ?? session('successHapusResep') ?? session('successEditResep') }}",
            timer: 1500,
            showConfirmButton: false
        });

        // HAPUS SESSION SUKSES AGAR TIDAK MUNCUL LAGI SAAT REFRESH
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endif

@endsection