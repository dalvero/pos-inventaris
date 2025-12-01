@extends('produk.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="mt-6 mr-4">
    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Produk</h2>
            <p class="text-sm font-semibold text-gray-600">Produk yang terdaftar di {{Auth::user()->toko->nama_toko}}.</p>
        </div>
    </div>

    {{-- SEARCH BAR --}}
    <form action="{{ route('produk.search') }}" method="GET" class="flex gap-4 mb-6 w-full">
        <div class="relative flex-1">
            <input
                type="text"
                name="query"
                value="{{ $query ?? '' }}"
                placeholder="Cari produk..."
                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500"
            >

            {{-- ICON SEARCH --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-gray-400 absolute left-3 top-2.5"
                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
            </svg>
        </div>

        <button
            type="submit"
            class="px-5 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition"
        >Cari</button>
    </form>


    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @if(isset($query))
            <p class="text-sm text-gray-500 mb-4">
                Hasil pencarian untuk: <strong>{{ $query }}</strong>
            </p>
        @endif
        {{-- CARD TAMBAH PRODUK --}}
        <div onclick="openProdukModal()"
            class="flex bg-white rounded-xl shadow-md hover:shadow-lg transition cursor-pointer">
            
            {{-- ICON AREA --}}
            <div class="w-32 h-full bg-orange-50 flex items-center justify-center rounded-l-xl group-hover:bg-orange-100 transition">
                <div class="w-20 h-20 flex items-center justify-center bg-white rounded-full shadow group-hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                        stroke-width="2" stroke="currentColor" class="w-10 h-10 text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
            </div>

            {{-- TEXT --}}
            <div class="flex-1 p-4 flex flex-col justify-center">
                <h3 class="font-bold text-gray-900 text-lg">Tambah Produk</h3>
                <p class="text-sm text-gray-500">Tambahkan produk baru ke toko</p>
            </div>
        </div>

        {{-- LIST PRODUK --}}
        @forelse ($produks as $produk)
            <div class="flex bg-white rounded-xl shadow-md hover:shadow-lg transition">
                {{-- FOTO PRODUK --}}
                <img
                    class="object-cover w-32 h-full rounded-l-xl"
                    src="{{ $produk->foto ? asset('storage/'.$produk->foto) : asset('storage/img/no_image.jpg') }}"
                    alt="{{ $produk->nama_produk }}"
                >

                <div class="flex-1 p-4 flex flex-col justify-between">

                    <div>
                        {{-- NAMA & STOCK --}}
                        <div class="flex justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $produk->nama_produk }}</h3>
                                <p class="text-xs text-gray-500">Produk</p>
                            </div>
                        </div>

                        {{-- HARGA --}}
                        <p class="text-lg font-bold text-orange-600">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-2 mt-2">
                        {{-- BUTTON DETAIL --}}
                        <button
                            onclick="editProduk({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, '{{ $produk->foto ? asset('storage/'.$produk->foto) : '' }}')"
                            class="flex-1 text-xs font-semibold cursor-pointer text-emerald-600 hover:bg-emerald-50 py-2 rounded-lg">
                            Detail
                        </button>

                        {{-- EDIT BUTTON --}}
                        <button
                            onclick="editProduk({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, '{{ $produk->foto ? asset('storage/'.$produk->foto) : '' }}')"
                            class="flex-1 text-xs font-semibold text-orange-600 hover:bg-orange-50 py-2 rounded-lg">
                            Edit
                        </button>

                        {{-- DELETE BUTTON --}}                                                                    
                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="cursor-pointer text-xs btn-delete font-semibold text-red-600 hover:bg-red-50 py-2 px-3 rounded-lg">
                                Hapus
                            </button>
                        </form>                        
                    </div>

                </div>
            </div>

        @empty
            <p class="text-gray-500 col-span-3 text-center py-6">Belum ada produk</p>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH/EDIT PRODUK --}}
<div id="produkModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    
    <div id="modalContent"
         class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative mx-4">

        <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Tambah Produk</h2>

        <form id="produkForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="POST">

            {{-- PREVIEW FOTO --}}
            <div id="previewContainer" class="mb-4 hidden">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Preview Foto</label>
                <div class="flex justify-center">
                    <img id="previewImage" src="" alt="Preview" class="w-40 h-40 object-cover rounded-lg border-2 border-gray-200">
                </div>
            </div>

            {{-- FOTO PRODUK --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Foto Produk</label>
                <input type="file" name="foto" id="inputFoto" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, JPEG (Max 2MB)</p>
            </div>

            {{-- NAMA PRODUK --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" id="inputNama" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                       placeholder="Masukkan nama produk">
            </div>

            {{-- HARGA --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Harga</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                    <input type="number" name="harga" id="inputHarga" required min="0"
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="0">
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeProdukModal()"
                        class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Batal
                </button>

                <button type="submit"
                        class="px-5 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT MODAL --}}
<script>
    // PREVIEW FOTO SAAT UPLOAD
    document.getElementById('inputFoto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    });

    // FUNCTION OPEN PRODUK MODAL
    function openProdukModal(mode = "create", data = null) {
        const modal = document.getElementById('produkModal');
        const form = document.getElementById('produkForm');
        const methodField = document.getElementById('methodField');
        const title = document.getElementById('modalTitle');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');

        // TAMPILAN MODAL DENGAN FLEX UNTUK CENTERING
        modal.classList.remove("hidden");
        modal.style.display = "flex";

        if (mode === "create") {
            title.textContent = "Tambah Produk";
            form.action = "{{ route('produk.store') }}";
            methodField.value = "POST";

            // RESET FORM
            document.getElementById('inputNama').value = "";
            document.getElementById('inputHarga').value = "";
            document.getElementById('inputFoto').value = "";
            previewContainer.classList.add('hidden');
        }

        if (mode === "edit" && data) {
            title.textContent = "Edit Produk";
            form.action = `/produk/${data.id}`;
            methodField.value = "PUT";

            document.getElementById('inputNama').value = data.nama_produk;
            document.getElementById('inputHarga').value = data.harga;
            document.getElementById('inputFoto').value = "";
            
            // TAMPILKAN PREVIEW FOTO EXISTING JIKA ADA
            if (data.foto) {
                previewImage.src = data.foto;
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    }

    // FUNCTION CLOSE PRODUK MODAL
    function closeProdukModal() {
        const modal = document.getElementById('produkModal');
        modal.classList.add("hidden");
        modal.style.display = "none";
    }

    // TUTUP MODAL SAAT KLIK DILUAR
    document.getElementById('produkModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProdukModal();
        }
    });

    // TRIGGER EDIT PRODUK\
    function editProduk(id, nama, harga, foto) {
        openProdukModal("edit", {
            id: id,
            nama_produk: nama,
            harga: harga,
            foto: foto
        });
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
                    title: 'Hapus Produk?',
                    text: "Produk yang dihapus tidak bisa dikembalikan.",
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
@if(session('successTambahProduk') || session('successHapusProduk'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('successTambahProduk') ?? session('successHapusProduk') }}",
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