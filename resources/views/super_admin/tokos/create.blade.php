@extends('super_admin.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Toko Baru</h2>
        <p class="text-sm font-semibold text-gray-600">
            Lengkapi form di bawah untuk menambahkan toko baru
        </p>
    </div>

    {{-- FORM CARD --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        <div class="p-6">
            <form action="{{ route('super_admin.tokos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- NAMA TOKO --}}
                <div class="mb-6">
                    <label for="nama_toko" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Toko <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_toko" 
                        name="nama_toko" 
                        value="{{ old('nama_toko') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nama_toko') @enderror"
                        placeholder="Masukkan nama toko"
                        required
                    >
                    @error('nama_toko')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ALAMAT --}}
                <div class="mb-6">
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('alamat') @enderror"
                        placeholder="Masukkan alamat lengkap toko"
                        required
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TELEPON --}}
                <div class="mb-6">
                    <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                        Telepon
                    </label>
                    <input 
                        type="text" 
                        id="telepon" 
                        name="telepon" 
                        value="{{ old('telepon') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('telepon') @enderror"
                        placeholder="Contoh: 081234567890"
                    >
                    @error('telepon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ADMIN TOKO --}}
                <div class="mb-6">
                    <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Admin Toko <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="user_id" 
                        name="user_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('user_id') @enderror
                        required
                    >
                        <option value="">Pilih Admin</option>
                        @forelse($admins as $admin)
                            <option value="{{ $admin->id }}" {{ old('user_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }} ({{ $admin->email }})
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada admin yang tersedia</option>
                        @endforelse
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hanya admin yang belum memiliki toko yang ditampilkan</p>
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- QR IMAGE --}}
                <div class="mb-6">
                    <label for="qr_image" class="block text-sm font-semibold text-gray-700 mb-2">
                        QR Code Image
                    </label>
                    <input 
                        type="file" 
                        id="qr_image" 
                        name="qr_image"
                        accept="image/jpeg,image/png,image/jpg"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('qr_image') @enderror"
                        onchange="previewImage(event)"
                    >
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                    @error('qr_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    
                    {{-- PREVIEW IMAGE --}}
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Preview:</p>
                        <img id="preview" src="" alt="Preview" class="max-w-xs h-auto rounded-lg shadow-lg">
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-linear-to-tr from-green-600 to-green-400 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition duration-200"
                    >
                        Simpan Toko
                    </button>
                    <a 
                        href="{{ route('super_admin.tokos.index') }}"
                        class="px-6 py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition duration-200"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const previewDiv = document.getElementById('imagePreview');
        const preview = document.getElementById('preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            previewDiv.classList.add('hidden');
        }
    }
</script>
@endsection