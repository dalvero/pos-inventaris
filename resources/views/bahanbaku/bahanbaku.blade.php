@extends('bahanbaku.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Manajemen Bahan Baku
            </h2>
            <p class="text-sm font-semibold text-gray-600">
                Kelola semua bahan baku di {{Auth::user()->toko->nama_toko}}
            </p>
        </div> 

        {{-- BUTTON TAMBAH BAHAN BAKU --}}
        <div onclick="openBahanBakuModal()">
            <button class="cursor-pointer flex items-center gap-2 px-4 py-2 bg-linear-to-tr from-violet-700 to-violet-950 text-white rounded-lg shadow-md shadow-violet-500/20 hover:shadow-lg hover:shadow-violet-500/40 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Bahan Baku
            </button>      
        </div>         
    </div>

    {{-- TABLE CARD --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        {{-- TABLE HEADER --}}
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Bahan Baku</h3>  
                <form action="{{ route('bahanbaku.search') }}" method="GET">              
                    {{-- SEARCH BAR --}}
                    <div class="relative">
                        <input 
                            type="text"
                            name="query"
                            value="{{ $query ?? '' }}"
                            placeholder="Cari bahan baku..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute left-3 top-2.5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
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
                        <th class="border-b border-gray-200 bg-gray-50 p-4">
                            <p class="block antialiased font-sans text-sm text-gray-900 font-semibold leading-none">
                                Aksi
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

                            {{-- AKSI --}}
                            <td class="p-4 border-b border-gray-200">
                                <div class="flex gap-2">
                                    {{-- EDIT --}}
                                    <button 
                                        onclick="editBahanBaku(
                                            {{ $bahan->id }},
                                            '{{ $bahan->nama_bahan }}',
                                            {{ $bahan->stok }},
                                            '{{ $bahan->satuan }}',
                                            {{ $bahan->minimum_stok }}
                                        )"
                                        class="cursor-pointer p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        </svg>
                                    </button>

                                    {{-- DELETE --}}
                                    <form method="POST" action="{{ route('bahanbaku.destroy', $bahan->id) }}" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete cursor-pointer p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18 .037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
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

{{-- MODAL TAMBAH/EDIT PRODUK --}}
<div id="bahanBakuModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    
    <div id="modalContent"
         class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative mx-4">

        <h2 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Tambah Bahan Baku</h2>

        <form id="bahanBakuForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="POST">
            
            {{-- NAMA BAHAN BAKU --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Nama Bahan Baku</label>
                <input type="text" name="nama_bahan" id="inputNamaBahanBaku" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                       placeholder="Masukkan nama bahan baku">
            </div>

            {{-- STOK --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Stok</label>
                <div class="relative">                    
                    <input type="number" name="stok" id="inputStok" required min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                        placeholder="0">
                </div>
            </div>

            {{-- SATUAN --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Satuan</label>
                <div class="relative">                    
                    <input type="text" name="satuan" id="inputSatuan" required min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                        placeholder="Kg, Liter, Butir, ml, dsb.">
                </div>
            </div>

            {{-- MINIMUM STOK --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2 text-gray-700">Stok Minimum</label>
                <div class="relative">                    
                    <input type="number" name="minimum_stok" id="inputMinimumStok" required min="0"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                        placeholder="0">
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeBahanBakuModal()"
                        class="cursor-pointer px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Batal
                </button>

                <button type="submit"
                        class="cursor-pointer px-5 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT MODAL --}}
<script>
    // FUNCTION OPEN BAHAN BAKU MODAL
    function openBahanBakuModal(mode = "create", data = null) {
        const modal = document.getElementById('bahanBakuModal');
        const form = document.getElementById('bahanBakuForm');
        const methodField = document.getElementById('methodField');
        const title = document.getElementById('modalTitle');

        // TAMPILAN MODAL DENGAN FLEX UNTUK CENTERING
        modal.classList.remove("hidden");
        modal.style.display = "flex";

        if (mode === "create") {
            title.textContent = "Tambah Bahan Baku";
            form.action = "{{ route('bahanbaku.store') }}";
            methodField.value = "POST";

            // RESET FORM
            document.getElementById('inputNamaBahanBaku').value = "";
            document.getElementById('inputStok').value = "";
            document.getElementById('inputSatuan').value = "";
            document.getElementById('inputMinimumStok').value = "";            
        }

        if (mode === "edit" && data) {
            title.textContent = "Edit Bahan Baku";
            form.action = `/bahanbaku/${data.id}`;
            methodField.value = "PUT";
            
            document.getElementById('inputNamaBahanBaku').value = data.nama_bahan;
            document.getElementById('inputStok').value = data.stok;
            document.getElementById('inputSatuan').value = data.satuan;
            document.getElementById('inputMinimumStok').value = data.minimum_stok;                
        }
    }

    // FUNCTION CLOSE BAHAN BAKu MODAL
    function closeBahanBakuModal() {
        const modal = document.getElementById('bahanBakuModal');
        modal.classList.add("hidden");
        modal.style.display = "none";
    }

    // TUTUP MODAL SAAT KLIK DILUAR
    document.getElementById('bahanBakuModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBahanBakuModal();
        }
    });

    // TRIGGER EDIT BAHAN BAKU
    function editBahanBaku(id, nama_bahan, stok, satuan, minimum_stok) {
        openBahanBakuModal("edit", {
            id: id,
            nama_bahan: nama_bahan,
            stok: stok,
            satuan: satuan,
            minimum_stok: minimum_stok            
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
                    title: 'Hapus Bahan Baku?',
                    text: "Bahan Baku yang dihapus tidak bisa dikembalikan.",
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
@if(session('successTambahBahanBaku') || session('successHapusBahanBaku'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('successTambahBahanBaku') ?? session('successHapusBahanBaku') }}",
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
