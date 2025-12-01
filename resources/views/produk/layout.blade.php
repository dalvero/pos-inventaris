<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko - Dashboard</title>
    @vite('resources/css/app.css')
    {{-- TOAST NOTIFICATION --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-graybg">

    <div class="min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="bg-linear-to-br from-orange-600/80 to-gray-900 -translate-x-80 fixed inset-0 z-50 my-4 ml-4 h-[calc(100vh-32px)] w-72 rounded-xl transition-transform duration-300 xl:translate-x-0 shadow-xl">
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
                        <a href="{{ route('produk.dashboard') }}" class="{{ request()->routeIs('produk.dashboard') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('produk.dashboard') ? 'bg-linear-to-tr from-orange-900 to-orange-400 text-white shadow-md shadow-orange-500/20 hover:shadow-lg hover:shadow-orange-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Dashboard</p>
                            </button>
                        </a>
                    </li>                    

                    {{-- PRODUK --}}
                    <li>
                        <a href="{{ route('produk.produk') }}" class="{{ request()->routeIs('produk.produk') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('produk.produk') ? 'bg-linear-to-tr  from-orange-900 to-orange-400 text-white shadow-md shadow-orange-500/20 hover:shadow-lg hover:shadow-orange-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path d="M2 3a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z" />
                                    <path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 0 1-1.99 1.79H4.802a2 2 0 0 1-1.99-1.79L2 7.5ZM7 11a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Produk</p>
                            </button>
                        </a>
                    </li>

                    {{-- BAHAN BAKU --}}
                    <li>
                        <a href="{{route('bahanbaku.dashboard')}}" class="{{ request()->routeIs('bahanbaku.dashboard') ? 'active' : ''}}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('bahanbaku.dashboard') ? 'bg-linear-to-tr  from-orange-900 to-orange-400 text-white shadow-md shadow-orange-500/20 hover:shadow-lg hover:shadow-orange-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Bahan Baku</p>
                            </button>
                        </a>
                    </li>
                </ul>

                {{-- BACK SECTION --}}
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