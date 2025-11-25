<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS & Inventory')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background font-sans text-muted">

    <nav class="bg-primary text-white px-6 py-4 shadow-card flex justify-between items-center">
        <a href="{{ route('home') }}" class="font-bold text-xl">POS-Inventaris</a>
        <div class="space-x-4">
            <a href="{{ route('home') }}" class="hover:text-accent">Home</a>
            <a href="{{ route('about') }}" class="hover:text-accent">About</a>
            <a href="{{ route('contact') }}" class="hover:text-accent">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-accent">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-accent">Logout</button> 
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-accent">Login</a>
            @endauth
        </div>
    </nav>

    <main class="p-6">
        @if(session('success'))
            <div class="bg-success text-white p-4 rounded-md mb-4 shadow-soft">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

</body>
</html>
