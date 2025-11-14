<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS & Inventory')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-whitebg font-sans text-gray-700 font-semibold">

    <div class="max-w-md mx-auto mt-20 p-6 bg-graybg border border-gray-700 rounded-lg">
        {{-- LOGO CONTAINER --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto">
        </div>                            
        <h2 class="text-3xl font-bold text-primary mb-6 text-center">Login</h2>
        <form action="{{ route('login') }}" method="POST" class="space-y-4 ">
            @csrf
            <input type="email" name="email" placeholder="Email" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
            {{-- REMEMBER ME & LUPA PASSWORD --}}
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" class="ml-2 w-5 h-5 cursor-pointer">
                    <span class="text-base font-semibold">Ingat saya</span>
                </label>
                <a href="#" class="text-md mr-2 text-primary hover:text-primary-hover font-semibold">Lupa Password?</a>
            </div>
            <button type="submit" class="w-full bg-primary text-2xl font-semibold cursor-pointer hover:bg-primary-hover text-white px-4 py-3 rounded-md">Login</button>
            {{-- BELUM PUNYA AKUN? REGISTER --}}
            <p class="text-center mt-4 text-base">
                Belum punya akun?
                <a href="{{ route('register')}}" class="text-primary font-semibold hover:text-primary-hover">Register</a>
            </p>
        </form>
    </div>
</body>
</html>


