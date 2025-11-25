<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | POS & Inventory</title>
    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

    <body class="bg-gray-100 font-sans text-gray-700 font-semibold">
        @if ($errors->any())
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-5 right-5 bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg animate-slide"
            >
                <p class="font-semibold">Form tidak lengkap!</p>
                <ul class="mt-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            @keyframes slide-in {
                from {
                    opacity: 0;
                    transform: translateX(50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .animate-slide {
                animation: slide-in 0.3s ease-out;
            }
        </style>



        <div class="max-w-md mx-auto mt-20 p-6 bg-graybg border border-gray-700 rounded-lg">

            {{-- LOGO --}}
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-auto">
            </div>

            <h2 class="text-2xl font-bold text-primary mb-6 text-center">Register Sebagai</h2>

            {{-- SWITCH BUTTON --}}
            <div class="flex mb-6 bg-gray-200 rounded-md p-1">
                <button id="btn-admin" class="cursor-pointer flex-1 py-2 rounded-md text-center bg-primary text-white font-semibold">
                    Admin Toko
                </button>
                <button id="btn-kasir" class="cursor-pointer flex-1 py-2 rounded-md text-center font-semibold">
                    Kasir
                </button>
            </div>

            {{-- FORM ADMIN TOKO --}}
            <form id="form-admin" action="{{ route('register') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="role" value="admin_toko">

                <input type="text" name="name" placeholder="Nama Admin" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="email" name="email" placeholder="Email Admin" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary  ">

                <input type="text" name="nama_toko" placeholder="Nama Toko" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">

                <button class="w-full bg-primary text-2xl font-semibold cursor-pointer hover:bg-primary-hover text-white px-4 py-3 rounded-md">Daftar Admin Toko</button>

                <p class="text-center mt-4 text-base">
                    Sudah punya akun?
                    <a href="{{ route('login')}}" class="text-primary font-semibold">Login</a>
                </p>
            </form>

            {{-- FORM KASIR (HIDDEN BY DEFAULT) --}}
            <form id="form-kasir" action="{{ route('register') }}" method="POST" class="space-y-3 hidden">
                @csrf
                <input type="hidden" name="role" value="kasir">

                <input type="text" name="name" placeholder="Nama Kasir" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="email" name="email" placeholder="Email Kasir" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="password" name="password" placeholder="Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">

                <select name="toko_id" class="w-full cursor-pointer p-3 border border-border rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">-- Pilih Toko --</option>
                    @foreach ($tokos as $toko)
                        <option value="{{ $toko->id }}">{{ $toko->nama_toko }}</option>
                    @endforeach
                </select>

                <button class="w-full bg-primary text-2xl font-semibold cursor-pointer hover:bg-primary-hover text-white px-4 py-3 rounded-md">Daftar Kasir</button>

                <p class="text-center mt-4 text-base">
                    Sudah punya akun?
                    <a href="{{ route('login')}}" class="text-primary font-semibold">Login</a>
                </p>
            </form>

        </div>

        {{-- SCRIPT TOGGLE --}}
        <script>
            const btnAdmin = document.getElementById("btn-admin");
            const btnKasir = document.getElementById("btn-kasir");
            const formAdmin = document.getElementById("form-admin");
            const formKasir = document.getElementById("form-kasir");

            btnAdmin.addEventListener("click", () => {
                btnAdmin.classList.add("bg-primary", "text-white");
                btnKasir.classList.remove("bg-primary", "text-white");
                formAdmin.classList.remove("hidden");
                formKasir.classList.add("hidden");
            });

            btnKasir.addEventListener("click", () => {
                btnKasir.classList.add("bg-primary", "text-white");
                btnAdmin.classList.remove("bg-primary", "text-white");
                formKasir.classList.remove("hidden");
                formAdmin.classList.add("hidden");
            });
        </script>
    </body>
</html>
