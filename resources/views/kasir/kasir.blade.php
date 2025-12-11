@extends('kasir.layout')

@section('breadcrumb', 'kasir')
@section('page-title', 'Manajemen Kasir')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="mt-6 mr-4">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Kelola kasir di {{Auth::user()->toko->nama_toko}}
        </h2>
        <p class="text-sm font-semibold text-gray-600">
            Berikut adalah kasir yang terdaftar di {{Auth::user()->toko->nama_toko}} milik anda.
        </p>
    </div>

    {{-- GRID KASIR --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {{-- CARD TAMBAH KASIR --}}
        <div onclick="openKasirModal()" class="relative flex flex-col bg-clip-border rounded-xl bg-linear-to-br from-blue-50 to-indigo-50 border-2 border-dashed border-blue-300 text-gray-700 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer group">            
            <div class="p-6 flex flex-col justify-center items-center h-full">
                <div class="mb-4 w-28 h-28 rounded-full bg-white flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-lg text-gray-700 font-bold mb-1">Tambah Kasir</p>
                    <p class="text-sm text-gray-500 font-medium">Daftarkan kasir baru</p>
                </div>
            </div>            
        </div>

        {{-- LOOPING KASIR --}}
        @forelse($kasirs as $kasir)
            <div class="relative flex flex-col bg-white rounded-xl text-gray-700 shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="p-6 flex flex-col justify-center items-center">
                    <div class="mb-4">
                        <img 
                            class="object-center object-cover rounded-full h-28 w-28 ring-4 ring-blue-100" 
                            src="{{ $kasir->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($kasir->name) }}" 
                            alt="{{ $kasir->name }}">
                    </div>
                    <div class="text-center">
                        <p class="text-lg text-gray-900 font-bold mb-1">{{ $kasir->name }}</p>
                        <p class="text-sm text-gray-500 font-medium mb-3">{{ $kasir->role ?? 'Kasir' }}</p>

                        {{-- STATUS SHIFT (OPENING/BREAK/CLOSING) --}}
                        <div class="flex items-center justify-center gap-2 text-xs text-gray-600">                            
                            @if(in_array($kasir->id, $kasirAktif))
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                    Opening
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 font-semibold">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
        
                {{-- DETAIL KASIR DAN HAPUS KASIR --}}
                <div class="border-t border-gray-100 px-6 py-3 justify-center flex gap-2">                    
                    {{-- DETAIL KASIR --}}
                    <button 
                        type="button"
                        onclick="openDetailKasir({{ $kasir->id }}, '{{ $kasir->name }}', '{{ $kasir->email }}', '{{ $kasir->created_at->format('d M Y, H:i') }}', '{{ $kasir->updated_at->format('d M Y, H:i') }}')"
                        class="cursor-pointer flex-1 text-center text-sm font-semibold text-blue-600 hover:text-blue-700 hover:bg-blue-100 py-2 px-3 rounded-lg transition">
                        Detail
                    </button>

                    {{-- DELETE KASIR --}}
                    <form action="{{ route('kasir.destroy', $kasir->id) }}" method="POST" class="flex-1 delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            class="cursor-pointer btn-delete block w-full text-center text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-100 py-2 px-3 rounded-lg transition">
                            Hapus
                        </button>
                    </form>

                </div>
            </div>
            @empty

            {{-- JIKA BELUM ADA KASIR --}}
            <div class="col-span-full text-center py-10 text-gray-500">
                Belum ada kasir terdaftar.
            </div>

        @endforelse        
    </div>

    {{-- STATISTIK --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Total Kasir</h3>
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{Auth::user()->toko->kasirs()->count()}}</p>
                <p class="text-xs text-gray-500 mt-1">Terdaftar di sistem</p>
            </div>
        </div>

        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-600">Sedang Bertugas</h3>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ count($kasirAktif) }}</p>
                <p class="text-xs text-gray-500 mt-1">Kasir aktif hari ini</p>
            </div>
        </div>        
    </div>
</div>

<!-- MODAL TAMBAH KASIR DENGAN BACKDROP TERINTEGRASI -->
<div id="modalKasir" 
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm"
     onclick="closeKasirModal()">
    
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-2xl relative animate-fadeIn mx-4"
         onclick="event.stopPropagation()">

        <!-- BUTTON CLOSE -->
        <button onclick="closeKasirModal()" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-xl text-gray-800 font-bold mb-5">Tambah Kasir</h2>

        <form action="{{ route('kasir.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1.5 text-sm">Nama</label>
                <input type="text" name="name" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" 
                       placeholder="Masukkan nama kasir"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1.5 text-sm">Email</label>
                <input type="email" name="email" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" 
                       placeholder="contoh@email.com"
                       required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-1.5 text-sm">Password</label>
                <input type="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" 
                       placeholder="Minimal 8 karakter"
                       required>
            </div>

            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-1.5 text-sm">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" 
                       placeholder="Ulangi password"
                       required>
            </div>

            <div class="flex gap-3">
                <button type="button"
                        onclick="closeKasirModal()"
                        class="flex-1 bg-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-gray-300 transition font-semibold">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-emerald-600 text-white py-2.5 rounded-lg hover:bg-emerald-700 transition font-semibold">
                    Tambah Kasir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DETAIL KASIR -->
<div id="detailKasirModal" 
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center"
     onclick="closeDetailKasir()">
    
    <div class="bg-white w-[380px] max-w-[90vw] rounded-2xl shadow-2xl overflow-hidden animate-fadeIn"
         onclick="event.stopPropagation()">

        <!-- HEADER -->
        <div class="text-center p-6 bg-linear-to-br from-emerald-600 to-emerald-700">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full mx-auto flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>

            <p id="detailNama" class="text-xl font-bold text-white"></p>
            <p id="detailEmail" class="text-sm text-emerald-100 mt-1"></p>

            <div class="mt-4">
                <span class="inline-block border-2 border-white/50 rounded-full py-1.5 px-4 text-xs font-semibold text-white bg-white/20 backdrop-blur-sm">
                    Kasir
                </span>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-5 space-y-3">
            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium mb-0.5">ID Kasir</p>
                    <p id="detailID" class="font-semibold text-gray-800"></p>
                </div>
            </div>

            <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Tanggal Dibuat</p>
                    <p id="detailCreated" class="font-semibold text-gray-800"></p>
                </div>
            </div>

            <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-lg">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium mb-0.5">Terakhir Update</p>
                    <p id="detailUpdated" class="font-semibold text-gray-800"></p>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="p-4 border-t border-gray-200 bg-gray-50 flex justify-end">
            <button onclick="closeDetailKasir()"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-semibold text-gray-700 transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- STYLE ANIMASI --}}
<style>
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: scale(0.95) translateY(-10px); 
        }
        to { 
            opacity: 1; 
            transform: scale(1) translateY(0); 
        }
    }
    .animate-fadeIn { 
        animation: fadeIn 0.2s ease-out; 
    }

    /* PREVENT SCCROLL SAAT MODAL TERBUKA */
    body.modal-open {
        overflow: hidden;
    }
</style>

{{-- SCRIPT OPEN/CLOSE MODAL TAMBAH KASIR --}}
<script>
    function openKasirModal() {
        const modal = document.getElementById('modalKasir');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('modal-open');
    }

    function closeKasirModal() {
        const modal = document.getElementById('modalKasir');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('modal-open');
    }

    // ESC KEY UNTUK CLOSE
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modalKasir = document.getElementById('modalKasir');
            const modalDetail = document.getElementById('detailKasirModal');
            
            if (modalKasir.classList.contains('flex')) {
                closeKasirModal();
            }
            if (modalDetail.classList.contains('flex')) {
                closeDetailKasir();
            }
        }
    });
</script>

{{-- SCRIPT OPEN/CLOSE MODAL DETAIL KASIR --}}
<script>
    function openDetailKasir(id, nama, email, created, updated) {
        // ISI DATA KE MODAL
        document.getElementById('detailID').textContent = id;
        document.getElementById('detailNama').textContent = nama;
        document.getElementById('detailEmail').textContent = email;
        document.getElementById('detailCreated').textContent = created;
        document.getElementById('detailUpdated').textContent = updated;

        // TAMPILKAN MODAL
        const detailModal = document.getElementById('detailKasirModal');
        detailModal.classList.remove('hidden');
        detailModal.classList.add('flex');
        document.body.classList.add('modal-open');
    }

    function closeDetailKasir() {
        const detailModal = document.getElementById('detailKasirModal');
        detailModal.classList.add('hidden');
        detailModal.classList.remove('flex');
        document.body.classList.remove('modal-open');
    }
</script>



{{-- SCRIPT SWEET ALERT KONFIRMASI HAPUS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('.delete-form');

                Swal.fire({
                    title: 'Hapus Kasir?',
                    text: "Kasir yang dihapus tidak bisa dikembalikan.",
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
@if(session('successDelete') || session('successCreate'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('successDelete') ?? session('successCreate') }}",
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