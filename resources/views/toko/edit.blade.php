@extends('layouts.app')
@section('title', 'Edit Data Toko')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- TITLE --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-primary">Edit Data Toko</h1>
        <p class="text-gray-600 mt-2">
            Perbarui informasi toko Anda pada form berikut.
        </p>
    </div>

    {{-- CARD FORM --}}
    <div class="p-8 rounded-xl shadow-md bg-white border border-gray-200">

        <form action="{{ route('toko.update', $toko->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA TOKO --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nama Toko
                </label>
                <input type="text" name="nama_toko"
                       value="{{ old('nama_toko', $toko->nama_toko) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary"
                       required>
                @error('nama_toko')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ALAMAT --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Alamat Toko
                </label>
                <textarea name="alamat" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">{{ old('alamat', $toko->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- NOMOR TELEPON --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nomor Telepon
                </label>
                <input type="text" name="telepon"
                       value="{{ old('telepon', $toko->telepon) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-primary focus:border-primary">
                @error('telepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- BUTTONS --}}
            <div class="flex justify-between mt-8">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium transition">
                    Kembali
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-primary text-white hover:bg-primary/80 font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
