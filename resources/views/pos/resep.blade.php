@extends('pos.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="mt-6 mr-4">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Lihat Resep dari Menumu</h2>
            <p class="text-sm font-semibold text-gray-600">Jangan sampai salah resep ya.</p>
        </div>
    </div>

    {{-- GRID PRODUK YANG SUDAH PUNYA RESEP --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

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

                    {{-- ACTION BUTTONS --}}
                    <div class="flex-1 p-4 flex flex-col justify-center">
                        <button onclick="openDetailResep({{ $produk->id }})"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full hover:bg-blue-700 transition">
                            Lihat Resep
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-3 text-center py-6">Belum ada produk berisi resep.</p>
        @endforelse
    </div>
</div>


<script>
    const resepProduks = @json($reseps);
    const produksWithResep = @json($produks);
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

@endsection