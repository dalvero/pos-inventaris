<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS & Inventory')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite('resources/css/app.css')

    {{-- TOAST NOTIFICATION --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-background font-sans text-muted">

    <nav class="bg-primary mb-5 text-white px-6 py-4 shadow-card flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3 font-bold text-xl">
            <img src="{{ asset('images/logo.png') }}" 
                alt="Logo" 
                class="w-10 h-10 rounded-full object-cover shadow-sm">
            POS - Inventaris
        </a>

        <div class="space-x-4">
            <a href="{{ route('home') }}" class="hover:text-accent font-semibold">Home</a>
            <a href="{{ route('about') }}" class="hover:text-accent font-semibold">About</a>
            <a href="{{ route('contact') }}" class="hover:text-accent font-semibold">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-accent font-semibold">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-accent cursor-pointer font-semibold">Logout</button> 
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-accent font-semibold">Login</a>
            @endauth
        </div>
        {{-- FIELD KOSONG  --}}
        <div class="w-25">
        </div>
    </nav>

    <main class="px-6">
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
                class="fixed right-5 top-5 z-50 w-[380px]
                    bg-white/60 backdrop-blur-xl 
                    rounded-xl shadow-lg px-6 py-4 
                    hover:bg-white/80 hover:shadow-2xl 
                    transition duration-150 ease-linear flex justify-between items-center"
            >
                <div>
                    <h1 class="text-base text-slate-800 font-semibold">
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
        @yield('content')
    </main>

</body>
</html>
