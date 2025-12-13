<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - POS & Inventory</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-whitebg font-sans text-gray-700 font-semibold">
    
    {{-- SUCCESS MESSAGE --}}
    @if (session('status'))
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            @click.away="show = false"
            class="fixed right-5 top-5 z-50 w-[380px] cursor-pointer
                bg-green-500/60 backdrop-blur-xl     
                rounded-xl shadow-lg px-6 py-4 text-white 
                hover:bg-green-500 hover:shadow-2xl
                transition duration-150 ease-linear"
            x-transition:enter="transform ease-out duration-300"
            x-transition:enter-start="translate-x-10 opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-10 opacity-0"
        >
            <div class="flex justify-between items-start">
                <h1 class="text-md font-semibold">Berhasil</h1>
                <button 
                    @click="show = false"
                    class="text-white cursor-pointer hover:text-gray-200 font-bold ml-4"
                >
                    ✕
                </button>
            </div>
            <p class="mt-2 text-sm">{{ session('status') }}</p>
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3500)"
            @click.away="show = false"
            class="fixed right-5 top-5 z-50 w-[380px] cursor-pointer
                bg-danger/60 backdrop-blur-xl     
                rounded-xl shadow-lg px-6 py-4 text-primary 
                hover:bg-danger hover:shadow-2xl hover:text-white
                transition duration-150 ease-linear"
            x-transition:enter="transform ease-out duration-300"
            x-transition:enter-start="translate-x-10 opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-10 opacity-0"
        >
            <div class="flex justify-between items-start">
                <h1 class="text-md font-semibold">Gagal mengirim email</h1>
                <button 
                    @click="show = false"
                    class="text-primary cursor-pointer hover:text-white font-bold ml-4"
                >
                    ✕
                </button>
            </div>
            <ul class="mt-2 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-md mx-auto mt-20 p-6 bg-graybg border border-gray-700 rounded-lg">
        
        {{-- LOGO CONTAINER --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto">
        </div>
        
        <h2 class="text-2xl font-bold text-primary mb-2 text-center">Reset Kata sandi</h2>
        <p class="text-center text-sm text-gray-600 mb-6">Masukkan Email untuk membuat kata sandi baru</p>
        
        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email" 
                    value="{{ old('email') }}"
                    required
                    class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-primary text-lg font-semibold cursor-pointer hover:bg-primary-hover text-white px-4 py-3 rounded-md transition"
            >
                Kirim
            </button>

            {{-- KEMBALI KE LOGIN --}}
            <p class="text-center mt-4 text-base">
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:text-primary-hover">Kembali ke Login</a>
            </p>
        </form>
    </div>
</body>
</html>