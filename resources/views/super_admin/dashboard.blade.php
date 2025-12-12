@extends('super_admin.layout')

@section('content')
<div class="p-4 xl:ml-0">
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Super Admin Dashboard
        </h2>
        <p class="text-sm font-semibold text-gray-600">
            Selamat datang! Berikut adalah overview dan statistik sistem secara keseluruhan.
        </p>
    </div>

    <!-- STATISTIK CARD -->
    <div class="mt-12">
        <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-4">
            <!-- CARD TOTAL USER -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-blue-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Total Users</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{ $totalUsers }}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-blue-500">{{ $totalUsers }}</strong>&nbsp;pengguna terdaftar di sistem
                    </p>
                </div>
            </div>

            <!-- CARD TOTAL TOKO -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-green-600 to-green-400 text-white shadow-green-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 0 0 7.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 0 0 4.902-5.652l-1.3-1.299a1.875 1.875 0 0 0-1.325-.549H5.223Z" />
                        <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 0 0 9.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 0 0 2.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3Zm3-6a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75v-3Zm8.25-.75a.75.75 0 0 0-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-5.25a.75.75 0 0 0-.75-.75h-3Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Total Toko</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{ $totalToko }}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-green-500">{{ $totalToko }}</strong>&nbsp;toko terdaftar di sistem
                    </p>
                </div>
            </div>

            <!-- CARD TOTAL ADMIN TOKO -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-orange-600 to-orange-400 text-white shadow-orange-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Admin Toko</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{ $totalAdminToko }}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-orange-500">{{ $totalAdminToko }}</strong>&nbsp;admin toko aktif
                    </p>
                </div>
            </div>

            <!-- CARD TOTAL KASIR -->
            <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                <div class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-linear-to-tr from-violet-600 to-violet-400 text-white shadow-violet-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                    </svg>
                </div>
                <div class="p-4 text-right">
                    <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">Total Kasir</p>
                    <h4 class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">{{ $totalKasir }}</h4>
                </div>
                <div class="border-t border-blue-gray-50 p-4">
                    <p class="block antialiased font-sans text-base leading-relaxed font-normal text-blue-gray-600">
                        <strong class="text-violet-500">{{ $totalKasir }}</strong>&nbsp;kasir terdaftar
                    </p>
                </div>
            </div>
        </div>    
    </div>

    {{-- TABEL USER TERBARU --}}
    <div class="mt-8 mb-12">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            {{-- TABLE HEADER --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">User Terbaru</h3>
                        <p class="text-xs text-gray-500 mt-1">5 user terakhir yang mendaftar di sistem</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- TABLE CONTENT --}}
            <div class="p-6 overflow-x-auto">
                @if($userTerbaru->count() > 0)
                    <table class="w-full min-w-max table-auto text-left">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 bg-gray-50 p-4">
                                    <p class="text-sm font-semibold text-gray-900">Nama</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4">
                                    <p class="text-sm font-semibold text-gray-900">Email</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4">
                                    <p class="text-sm text-center font-semibold text-gray-900">Role</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4">
                                    <p class="text-sm font-semibold text-gray-900">Toko</p>
                                </th>
                                <th class="border-b border-gray-200 bg-gray-50 p-4">
                                    <p class="text-sm text-center font-semibold text-gray-900">Terdaftar</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userTerbaru as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-center">
                                        @if($user->role === 'super_admin')
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                Super Admin
                                            </span>
                                        @elseif($user->role === 'admin')
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">
                                                Admin Toko
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                                Kasir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm text-gray-600">
                                            {{ $user->toko ? $user->toko->nama_toko : '-' }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200 text-center">
                                        <p class="text-xs text-gray-500">
                                            {{ $user->created_at->diffForHumans() }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <p class="text-gray-500 font-semibold">Belum ada user terdaftar</p>
                        <p class="text-sm text-gray-400 mt-2">Data user akan muncul setelah ada pendaftaran</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- TABEL TOKO TERBARU --}}    
    <div class="mt-8 mb-12">
        <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
            {{-- TABLE HEADER --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Toko Terbaru</h3>
                        <p class="text-xs text-gray-500 mt-1">5 toko terakhir yang terdaftar di sistem</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- TABLE CONTENT --}}
            <div class="p-6 overflow-x-auto">
                @if($tokoTerbaru->count() > 0)
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
                                <th class="border-b border-gray-200 bg-gray-50 p-4">
                                    <p class="text-sm text-center font-semibold text-gray-900">Terdaftar</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokoTerbaru as $toko)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">{{ $toko->nama_toko }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $toko->id }}</p>
                                    </td>
                                    <td class="p-4 border-b border-gray-200">
                                        <p class="text-sm text-gray-600">{{ Str::limit($toko->alamat, 40) }}</p>
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
                                        <p class="text-xs text-gray-500">
                                            {{ $toko->created_at->diffForHumans() }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l4.318-4.318A4.5 4.5 0 0 1 14.25 3l1.318-.218a4.5 4.5 0 0 1 4.398 3.098l.75 3.007a4.5 4.5 0 0 1-1.327 4.568L15 18m-1.5 3h-4.5" />
                        </svg>
                        <p class="text-gray-500 font-semibold">Belum ada toko terdaftar</p>
                        <p class="text-sm text-gray-400 mt-2">Data toko akan muncul setelah ada pendaftaran</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection