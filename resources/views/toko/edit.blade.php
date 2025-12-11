@extends('toko.layout')

@section('content')
<div class="p-4 xl:ml-0">

    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Edit data {{Auth::user()->toko->nama_toko}}
        </h2>
        <p class="text-sm font-semibold text-gray-600">
            Perbarui data melalui form berikut.
        </p>
    </div>

    {{-- CARD FORM --}}
    <div class="p-8 rounded-xl shadow-md bg-white border border-gray-200">

        <form action="{{ route('toko.update', $toko->id) }}" method="POST" enctype="multipart/form-data">
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

            {{-- QR PEMBAYARAN --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Upload QR Pembayaran (QRIS)
                </label>

                <input type="file" name="qr_image"
                    accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white cursor-pointer focus:ring-primary focus:border-primary">

                @error('qr_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                {{-- PREVIEW GAMBAR LAMA --}}
                @if ($toko->qr_image)
                    <div class="mt-4">
                        <p class="text-gray-700 font-medium mb-2">QR Saat Ini:</p>
                        <img src="{{ asset('storage/' . $toko->qr_image) }}"
                             class="w-40 border rounded-lg shadow">
                    </div>
                @endif
            </div>

            {{-- BUTTONS --}}
            <div class="flex justify-between mt-8"> 
                <button type="submit"
                        class="cursor-pointer px-6 py-2 rounded-lg bg-primary text-white hover:bg-primary/80 font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
