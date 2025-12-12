<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko - Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite('resources/css/app.css')
    {{-- TOAST NOTIFICATION --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-graybg">

    <div class="min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="bg-linear-to-br from-primary to-gray-900 -translate-x-80 fixed inset-0 z-50 my-4 ml-4 h-[calc(100vh-32px)] w-72 rounded-xl transition-transform duration-300 xl:translate-x-0 shadow-xl">
            {{-- HEADER SIDEBAR --}}
            <div class="relative border-b border-white/20">
                <a class="flex items-center gap-4 py-4 px-8" href="{{ route('toko.dashboard') }}">
                    <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-white">{{Auth::user()->toko->nama_toko}}</h6>
                </a>
            </div>

            {{-- NAVIGATION MENU --}}
            <div class="m-4">
                {{-- DASHBOARD --}}
                <ul class="mb-4 flex flex-col gap-1">
                    <li>
                        <a href="{{ route('toko.dashboard') }}" class="{{ request()->routeIs('toko.dashboard') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('toko.dashboard') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Dashboard</p>
                            </button>
                        </a>
                    </li>

                    {{-- EDIT TOKO --}}                    
                    <li>
                        @if(Auth::user()->toko)
                            {{-- JIKA USER SUDAH PUNYA TOKO -> TOMBOL EDIT --}}
                            <a href="{{ route('toko.edit', Auth::user()->toko->id) }}" class="{{ request()->routeIs('toko.edit', Auth::user()->toko->id) ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('toko.edit', Auth::user()->toko->id) ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Edit Toko</p>                            
                            </button>
                            </a>
                        @else
                            {{-- JIKA BELUM PUNYA TOKO -> TOMBOL TAMBAH --}}                            
                            <a href="{{ route('toko.create', Auth::user()->toko->id) }}" class="{{ request()->routeIs('toko.create', Auth::user()->toko->id) ? 'active' : '' }}">
                                <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('toko.edit', Auth::user()->toko->id) ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Tambah Toko</p>                            
                                </button>
                            </a>
                        @endif

                    </li>

                    {{-- PRODUK --}}
                    <li>
                        <a href="{{ route('produk.produk') }}"  class="{{ request()->routeIs('produk.produk') ? 'active' : ''}}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('produk.produk') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>

                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Produk</p>
                            </button>
                        </a>
                    </li>

                    {{-- KASIR --}}
                    <li>
                        <a href="{{ route('kasir.kasir') }}" class="{{ request()->routeIs('kasir.kasir') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('kasir.kasir') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Kasir</p>
                            </button>
                        </a>
                    </li>

                    {{-- BAHAN BAKU --}}
                    <li>
                        <a href="{{ route('bahanbaku.bahanbaku') }}" class="{{ request()->routeIs('bahanbaku.bahanbaku') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('bahanbaku.bahanbaku') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Bahan Baku</p>
                            </button>
                        </a>
                    </li>

                    {{-- RESEP PRODUK --}}
                    <li>
                        <a href="{{ route('resep.resep') }}" class="{{ request()->routeIs('resep.resep') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('resep.resep') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 14.25 6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185ZM9.75 9h.008v.008H9.75V9Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 4.5h.008v.008h-.008V13.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Resep Produk</p>
                            </button>
                        </a>
                    </li>

                    {{-- TRANSAKSI HARI INI --}}                    
                    <li>
                        <a href="{{ route('toko.transaksi') }}" class="{{ request()->routeIs('toko.transaksi') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('toko.transaksi') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM12 18.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Transaksi</p>
                            </button>
                        </a>
                    </li>
                </ul>

                {{-- LOGOUT SECTION --}}
                <ul class="mb-4 flex flex-col border-t border-white/20 gap-1">
                    <li>
                        <a href="{{route('dashboard')}}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg text-white hover:bg-white/10 active:bg-white/30 w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Kembali</p>
                            </button>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="p-3 xl:ml-80">
            {{-- TOAST NOTIF --}}
            @if(session('success'))
                <div 
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3500)" 
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    class="cursor-pointer fixed right-5 top-5 z-50 w-[380px]
                        bg-success backdrop-blur-xl 
                        rounded-xl shadow-lg px-6 py-4 
                        hover:bg-success/80 hover:shadow-2xl 
                        transition duration-150 ease-linear flex justify-between items-center"
                >
                    <div>
                        <h1 class="text-base text-white font-semibold">
                            {{ session('success') }}
                        </h1>
                    </div>

                    <button 
                        @click="show = false" 
                        class="text-slate-500 cursor-pointer hover:text-slate-700 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
            {{-- MAIN CONTENT ARE --}}
            <main class="mt-2">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>