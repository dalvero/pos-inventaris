@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- HERO SECTION -->
<div class="relative overflow-hidden bg-linear-to-br from-primary via-primary to-primary/90 text-white -mt-5 -mx-6">
    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
    <div class="container mx-auto px-6 py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
                Kelola Bisnis Anda dengan <span class="text-accent">Mudah & Efisien</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-white/90 leading-relaxed">
                Sistem Point of Sale dan Manajemen Inventaris terintegrasi untuk usaha minuman dan makanan Anda
            </p>
            <div class="mb-4 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('login') }}" 
                   class="bg-accent hover:bg-accent/90 hover:text-white text-primary font-bold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                    Mulai Sekarang
                </a>
                <a href="{{ route('about') }}" 
                   class="bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold px-8 py-4 rounded-lg border-2 border-white/30 transition-all duration-200">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
    <!-- WAVE DECORATION -->
    <div class="absolute -bottom-0.5 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" 
                  fill="#f5f5f5"/>
        </svg>
    </div>
</div>

<!-- FEATURES SECTION -->
<div class="container mx-auto px-6 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-primary mb-4">Fitur Unggulan</h2>
        <p class="text-lg text-muted max-w-2xl mx-auto">
            Solusi lengkap untuk mengelola penjualan dan stok dengan lebih efektif
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- FEATURE 1 -->
        <div class="bg-white rounded-xl shadow-card hover:shadow-lg p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
            <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-primary mb-3">Point of Sale</h3>
            <p class="text-muted leading-relaxed">
                Proses transaksi cepat dan mudah dengan interface yang user-friendly. Dukung berbagai metode pembayaran.
            </p>
        </div>

        <!-- FEATURE 2 -->
        <div class="bg-white rounded-xl shadow-card hover:shadow-lg p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
            <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-primary mb-3">Manajemen Inventaris</h3>
            <p class="text-muted leading-relaxed">
                Pantau stok real-time, kelola produk, dan dapatkan notifikasi otomatis saat stok menipis.
            </p>
        </div>

        <!-- FEATURE 3 -->
        <div class="bg-white rounded-xl shadow-card hover:shadow-lg p-8 transition-all duration-300 hover:-translate-y-2 border border-gray-100">
            <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-primary mb-3">Laporan Lengkap</h3>
            <p class="text-muted leading-relaxed">
                Analisa penjualan dan performa bisnis dengan laporan detail dan visual yang mudah dipahami.
            </p>
        </div>
    </div>
</div>

<!-- BENEFITS SECTION -->
<div class="bg-gray-50 py-16 -mx-6">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-primary mb-6">
                        Mengapa Memilih Sistem Kami?
                    </h2>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Mudah Digunakan</h4>
                                <p class="text-muted">Interface intuitif yang dapat dipelajari dalam hitungan menit</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Hemat Waktu</h4>
                                <p class="text-muted">Otomasi proses bisnis dan kurangi pekerjaan manual</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Data Aman</h4>
                                <p class="text-muted">Keamanan data terjamin dengan enkripsi modern</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-primary text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-1">Support 24/7</h4>
                                <p class="text-muted">Tim support siap membantu kapan saja Anda membutuhkan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-linear-to-br from-primary to-primary/80 rounded-2xl p-8 shadow-xl">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 mb-4">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-white/80 font-semibold">Total Penjualan Hari Ini</span>
                                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h3 class="text-4xl font-bold text-white mb-2">Rp 15.750.000</h3>
                            <p class="text-accent font-semibold">+24% dari kemarin</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                <p class="text-white/80 text-sm mb-1">Transaksi</p>
                                <p class="text-2xl font-bold text-white">127</p>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                <p class="text-white/80 text-sm mb-1">Produk Terjual</p>
                                <p class="text-2xl font-bold text-white">342</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA SECTION -->
<div class="container mx-auto px-6 py-16">
    <div class="bg-linear-to-r from-primary to-primary/90 rounded-2xl shadow-xl p-12 text-center text-white">
        <h2 class="text-4xl font-bold mb-4">Siap Tingkatkan Bisnis Anda?</h2>
        <p class="text-xl mb-8 text-white/90 max-w-2xl mx-auto">
            Bergabunglah dengan ratusan bisnis yang sudah mempercayai sistem kami untuk mengelola operasional mereka
        </p>
        <a href="{{ route('login') }}" 
           class="inline-block bg-accent hover:bg-accent/90 text-primary font-bold px-10 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
            Coba Gratis Sekarang
        </a>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-primary text-white -mx-6 mt-12">
    <div class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <!-- BRAND -->
            <div class="md:col-span-1">
                <h3 class="font-bold text-2xl mb-4">POS-Inventaris</h3>
                <p class="text-white/80 leading-relaxed">
                    Solusi terpadu untuk manajemen penjualan dan inventaris bisnis Anda.
                </p>
            </div>
            
            <!-- QUICK LINES -->
            <div>
                <h4 class="font-bold text-lg mb-4">Menu</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-white/80 hover:text-accent transition">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-white/80 hover:text-accent transition">About</a></li>
                    <li><a href="{{ route('contact') }}" class="text-white/80 hover:text-accent transition">Contact</a></li>
                    <li><a href="{{ route('login') }}" class="text-white/80 hover:text-accent transition">Login</a></li>
                </ul>
            </div>
            
            <!-- FEATURES -->
            <div>
                <h4 class="font-bold text-lg mb-4">Fitur</h4>
                <ul class="space-y-2 text-white/80">
                    <li>Point of Sale</li>
                    <li>Manajemen Inventaris</li>
                    <li>Laporan Penjualan</li>
                    <li>Analisa Bisnis</li>
                </ul>
            </div>
            
            <!-- CONTACT INFO -->
            <div>
                <h4 class="font-bold text-lg mb-4">Kontak</h4>
                <ul class="space-y-2 text-white/80">
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@pos-inventaris.com
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +62 812-3456-7890
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Malang, Jawa Timur, Indonesia
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- BOTTOM BAR -->
        <div class="border-t border-white/20 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/80 text-sm">
                &copy; 2024 POS-Inventaris. All rights reserved.
            </p>
            <div class="flex gap-4">
                <a href="#" class="text-white/80 hover:text-accent transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" class="text-white/80 hover:text-accent transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                    </svg>
                </a>
                <a href="#" class="text-white/80 hover:text-accent transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out;
}

.bg-grid-pattern {
    background-image: 
        linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 40px 40px;
}
</style>
@endsection