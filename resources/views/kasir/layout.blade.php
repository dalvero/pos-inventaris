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
        <aside class="bg-linear-to-br from-secondary/80 to-gray-900 -translate-x-80 fixed inset-0 z-50 my-4 ml-4 h-[calc(100vh-32px)] w-72 rounded-xl transition-transform duration-300 xl:translate-x-0 shadow-xl">
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
                        <a href="{{ route('kasir.dashboard') }}" class="{{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('kasir.dashboard') ? 'bg-linear-to-tr from-emerald-800 to-emerald-400 text-white shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Dashboard</p>
                            </button>
                        </a>
                    </li>                    

                    {{-- KASIR --}}
                    <li>
                        <a href="{{ route('kasir.kasir') }}" class="{{ request()->routeIs('kasir.kasir') ? 'active' : '' }}">
                            <button class="cursor-pointer middle none font-sans font-bold center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg {{ request()->routeIs('kasir.kasir') ? 'bg-linear-to-tr  from-emerald-800 to-emerald-400 text-white shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/40' : 'text-white hover:bg-white/10' }} active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">Kasir</p>
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