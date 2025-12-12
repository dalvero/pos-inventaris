@extends('super_admin.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
        <p class="text-sm font-semibold text-gray-600">
            Perbarui informasi user
        </p>
    </div>

    {{-- FORM CARD --}}
    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
        <div class="p-6">
            <form action="{{ route('super_admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- NAMA --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') @enderror"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') @enderror"
                        placeholder="contoh@email.com"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Baru <span class="text-gray-500">(Kosongkan jika tidak ingin mengubah)</span>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') @enderror"
                        placeholder="Minimal 6 karakter"
                    >
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ulangi password baru"
                    >
                </div>

                {{-- ROLE --}}
                <div class="mb-6">
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="role" 
                        name="role"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') @enderror"
                        required
                        onchange="toggleTokoField()"
                    >
                        <option value="">Pilih Role</option>
                        <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin Toko</option>
                        <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TOKO --}}
                <div class="mb-6" id="tokoField" style="display: none;">
                    <label for="toko_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Toko <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="toko_id" 
                        name="toko_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('toko_id') @enderror"
                    >
                        <option value="">Pilih Toko</option>
                        @foreach($tokos as $toko)
                            <option value="{{ $toko->id }}" {{ old('toko_id', $user->toko_id) == $toko->id ? 'selected' : '' }}>
                                {{ $toko->nama_toko }}
                            </option>
                        @endforeach
                    </select>
                    @error('toko_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- BUTTONS --}}
                <div class="flex gap-3 pt-4">
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-linear-to-tr from-blue-600 to-blue-400 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition duration-200"
                    >
                        Update User
                    </button>
                    <a 
                        href="{{ route('super_admin.users.index') }}"
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
    function toggleTokoField() {
        const role = document.getElementById('role').value;
        const tokoField = document.getElementById('tokoField');
        const tokoSelect = document.getElementById('toko_id');
        
        if (role === 'admin' || role === 'kasir') {
            tokoField.style.display = 'block';
            tokoSelect.required = true;
        } else {
            tokoField.style.display = 'none';
            tokoSelect.required = false;
            tokoSelect.value = '';
        }
    }

    // CHECK ON PAGE LOAD
    document.addEventListener('DOMContentLoaded', function() {
        toggleTokoField();
    });
</script>
@endsection