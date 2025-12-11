<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Pesanan</title>
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
                <a class="flex items-center gap-4 py-4 px-8" href="{{ route('pos.menupesanan') }}">
                    <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-white">{{Auth::user()->toko->nama_toko}}</h6>
                </a>
            </div>

            {{-- NAVIGATION MENU --}}
            <div class="m-4">
                {{-- MENU PESANAN --}}
                <ul class="mb-4 flex flex-col gap-1">
                    <li>
                        <a href="{{ route('pos.menupesanan') }}" class="{{ request()->routeIs('pos.menupesanan') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('pos.menupesanan') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <rect width="18" height="18" x="3" y="3" rx="2" stroke-width="1.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12h10"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16h10"/>
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Menu Pesanan</p>
                            </button>
                        </a>
                    </li>

                    {{-- RESEP PRODUK --}}
                    <li>
                        <a href="{{ route('pos.resep') }}" class="{{ request()->routeIs('pos.resep') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('pos.resep') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 17h12"/>
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Resep Produk</p>
                            </button>
                        </a>
                    </li>

                    {{-- BAHAN BAKU --}}
                    <li>
                        <a href="{{ route('pos.bahanbaku') }}" class="{{ request()->routeIs('pos.bahanbaku') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('pos.bahanbaku') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.528V3a1 1 0 0 1 1-1h0"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.237 21A15 15 0 0 0 22 11a6 6 0 0 0-10-4.472A6 6 0 0 0 2 11a15.1 15.1 0 0 0 3.763 10 3 3 0 0 0 3.648.648 5.5 5.5 0 0 1 5.178 0A3 3 0 0 0 18.237 21"/>
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Bahan Baku</p>
                            </button>
                        </a>
                    </li>

                    {{-- TRANSAKSI --}}
                    <li>
                        <a href="{{ route('pos.transaksi') }}" class="{{ request()->routeIs('pos.transaksi') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('pos.transaksi') ? 'bg-linear-to-tr from-blue-600 to-blue-400 text-white shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <rect width="20" height="12" x="2" y="6" rx="2" stroke-width="1.5"/>
                                    <circle cx="12" cy="12" r="2" stroke-width="1.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h.01M18 12h.01"/>
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