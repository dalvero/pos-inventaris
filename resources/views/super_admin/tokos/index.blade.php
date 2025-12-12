@extends('super_admin.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Toko</h2>
            <p class="text-sm font-semibold text-gray-600">
                Kelola semua toko yang terdaftar di sistem
            </p>
        </div>
        <a href="{{ route('super_admin.tokos.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-linear-to-tr from-green-600 to-green-400 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Toko
        </a>
    </div>

    {{-- TABLE TOKO --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        <div class="p-6 overflow-x-auto">
            @if($tokos->count() > 0)
                <table class="w-full min-w-max table-auto text-left">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Nama Toko</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Alamat</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Telepon</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Admin</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm font-semibold text-gray-900">QR Code</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm font-semibold text-gray-900">Terdaftar</p>
                            </th>
                            <th class="border-b border-gray-200 bg-gray-50 p-4 text-center">
                                <p class="text-sm font-semibold text-gray-900">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tokos as $toko)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-900">{{ $toko->nama_toko }}</p>
                                    <p class="text-xs text-gray-500">ID: #{{ $toko->id }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-600">{{ Str::limit($toko->alamat, 50) }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-600">{{ $toko->telepon ?? '-' }}</p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <p class="text-sm text-gray-900">
                                        {{ $toko->admin ? $toko->admin->name : '-' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $toko->admin ? $toko->admin->email : '' }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-gray-200 text-center">
                                    @if($toko->qr_image)
                                        <button 
                                            onclick="showQRModal('{{ asset('storage/' . $toko->qr_image) }}', '{{ $toko->nama_toko }}')"
                                            class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 hover:bg-green-200 transition"
                                        >
                                            Lihat QR
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-4 border-b border-gray-200 text-center">
                                    <p class="text-xs text-gray-500">
                                        {{ $toko->created_at->format('d M Y') }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-gray-200">
                                    <div class="flex justify-center gap-2">
                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route('super_admin.tokos.edit', $toko->id) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        
                                        {{-- TOMBOL DELETE --}}
                                        <form action="{{ route('super_admin.tokos.destroy', $toko->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus toko ini? Semua data terkait akan terhapus!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                <div class="mt-6">
                    {{ $tokos->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>
                    <p class="text-gray-500 font-semibold">Belum ada toko terdaftar</p>
                    <p class="text-sm text-gray-400 mt-2">Klik tombol "Tambah Toko" untuk menambahkan toko baru</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL QR CODE --}}
<div id="qrModal" class="fixed inset-0 backdrop-blur-md bg-black/20 hidden items-center justify-center z-50" onclick="closeQRModal()">
    <div class="bg-white rounded-xl p-6 max-w-md mx-4" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800" id="qrModalTitle">QR Code</h3>
            <button onclick="closeQRModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex justify-center">
            <img id="qrModalImage" src="" alt="QR Code" class="max-w-full h-auto rounded-lg shadow-lg">
        </div>
    </div>
</div>

<script>
    function showQRModal(imageUrl, tokoName) {
        document.getElementById('qrModal').classList.remove('hidden');
        document.getElementById('qrModal').classList.add('flex');
        document.getElementById('qrModalImage').src = imageUrl;
        document.getElementById('qrModalTitle').textContent = 'QR Code - ' + tokoName;
    }

    function closeQRModal() {
        document.getElementById('qrModal').classList.add('hidden');
        document.getElementById('qrModal').classList.remove('flex');
    }
</script>
@endsection