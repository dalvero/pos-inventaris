@extends('layouts.app')

@section('title', 'About')

@section('content')
<!-- HERO SECTION -->
<div class="relative overflow-hidden bg-linear-to-br from-primary via-primary to-primary/90 text-white -mt-4 -mx-6">
    <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
    <div class="container mx-auto px-6 py-16 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-10">Tentang Kami</h1>
            <p class="text-xl text-white/90 leading-relaxed mb-15">
                Membangun solusi terbaik untuk bisnis F&B Indonesia
            </p>
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

<!-- MAIN CONTENT -->
<div class="container mx-auto px-6 py-16">
    <!-- VISI MISI -->
    <div class="max-w-4xl mx-auto mb-16">
        <div class="bg-white rounded-2xl shadow-card p-8 md:p-12 border border-gray-100">
            <h2 class="text-3xl font-bold text-primary mb-6 text-center">Visi & Misi Kami</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="bg-primary/10 w-14 h-14 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Visi</h3>
                    <p class="text-muted leading-relaxed">
                        Menjadi platform Point of Sale dan manajemen inventaris terdepan yang memberdayakan UMKM di Indonesia untuk berkembang dengan teknologi modern.
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="bg-primary/10 w-14 h-14 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Misi</h3>
                    <p class="text-muted leading-relaxed">
                        Menyediakan sistem yang mudah, efisien, dan terjangkau untuk membantu pelaku usaha mengelola bisnis mereka dengan lebih baik dan profesional.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CERITA KITA -->
    <div class="max-w-4xl mx-auto mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-primary mb-4">Cerita Kami</h2>
            <p class="text-lg text-muted">Perjalanan menciptakan solusi untuk bisnis Indonesia</p>
        </div>
        <div class="bg-linear-to-br from-primary/5 to-transparent rounded-2xl p-8 md:p-12 border-l-4 border-primary">
            <p class="text-muted leading-relaxed mb-4">
                Aplikasi POS & Inventaris dimulai dari pengalaman langsung dalam mengelola bisnis makanan dan minuman. Kami memahami tantangan yang dihadapi pelaku usaha dalam mencatat transaksi, mengelola stok, dan menganalisa performa bisnis.
            </p>
            <p class="text-muted leading-relaxed mb-4">
                Dengan memanfaatkan teknologi modern seperti Laravel 12 dan Tailwind CSS, kami mengembangkan platform berbasis web yang powerful namun tetap mudah digunakan. Setiap fitur dirancang berdasarkan kebutuhan nyata dari pelaku usaha di lapangan.
            </p>
            <p class="text-muted leading-relaxed">
                Hari ini, kami bangga dapat membantu ratusan bisnis dalam mengelola operasional mereka dengan lebih efisien, menghemat waktu, dan meningkatkan profitabilitas.
            </p>
        </div>
    </div>

    <!-- TECHNOLOGY STACK -->
    <div class="max-w-5xl mx-auto mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-primary mb-4">Teknologi yang Kami Gunakan</h2>
            <p class="text-lg text-muted">Dibangun dengan teknologi modern dan terpercaya</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-card hover:shadow-lg p-8 transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-2">Laravel 12</h3>
                <p class="text-muted text-sm">Framework PHP modern untuk backend yang robust dan scalable</p>
            </div>
            <div class="bg-white rounded-xl shadow-card hover:shadow-lg p-8 transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-2">Tailwind CSS</h3>
                <p class="text-muted text-sm">Utility-first CSS framework untuk UI yang indah dan responsif</p>
            </div>
            <div class="bg-white rounded-xl shadow-card hover:shadow-lg p-8 transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-green-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-2">MySQL</h3>
                <p class="text-muted text-sm">Database yang reliable untuk menyimpan data bisnis Anda</p>
            </div>
        </div>
    </div>

    <!-- CORE VALUES -->
    <div class="max-w-5xl mx-auto mb-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-primary mb-4">Nilai-Nilai Kami</h2>
            <p class="text-lg text-muted">Prinsip yang memandu setiap keputusan kami</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-card p-6 border-l-4 border-primary hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold text-primary mb-3 flex items-center gap-3">
                    <span class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                    Kemudahan Penggunaan
                </h3>
                <p class="text-muted leading-relaxed">
                    Kami percaya teknologi harus memudahkan, bukan memperumit. Setiap fitur dirancang agar intuitif dan mudah dipelajari.
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-card p-6 border-l-4 border-primary hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold text-primary mb-3 flex items-center gap-3">
                    <span class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                    Keamanan Data
                </h3>
                <p class="text-muted leading-relaxed">
                    Data bisnis Anda adalah aset berharga. Kami menggunakan enkripsi modern dan best practices untuk menjaga keamanannya.
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-card p-6 border-l-4 border-primary hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold text-primary mb-3 flex items-center gap-3">
                    <span class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                    Inovasi Berkelanjutan
                </h3>
                <p class="text-muted leading-relaxed">
                    Kami terus mengembangkan fitur baru berdasarkan feedback pengguna dan tren teknologi terkini.
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-card p-6 border-l-4 border-primary hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold text-primary mb-3 flex items-center gap-3">
                    <span class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">4</span>
                    Dukungan Pelanggan
                </h3>
                <p class="text-muted leading-relaxed">
                    Tim support kami siap membantu Anda 24/7. Kesuksesan bisnis Anda adalah kesuksesan kami.
                </p>
            </div>
        </div>
    </div>

    <!-- STATISTICS -->
    <div class="bg-linear-to-br from-primary to-primary/90 rounded-2xl shadow-xl p-12 text-white -mx-6">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Dampak Kami</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold text-accent mb-2">500+</div>
                    <p class="text-white/90">Bisnis Terdaftar</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-accent mb-2">50K+</div>
                    <p class="text-white/90">Transaksi Harian</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-accent mb-2">98%</div>
                    <p class="text-white/90">Kepuasan Pelanggan</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-accent mb-2">24/7</div>
                    <p class="text-white/90">Support Tersedia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="max-w-4xl mx-auto text-center mt-16">
        <h2 class="text-3xl font-bold text-primary mb-4">Siap Bergabung dengan Kami?</h2>
        <p class="text-lg text-muted mb-8">
            Mulai transformasi digital bisnis Anda hari ini
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('login') }}" 
               class="bg-primary hover:bg-primary/90 text-white font-bold px-8 py-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                Mulai Sekarang
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-white hover:bg-gray-50 text-primary font-semibold px-8 py-4 rounded-lg border-2 border-primary transition-all duration-200">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>

<style>
.bg-grid-pattern {
    background-image: 
        linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 40px 40px;
}
</style>
@endsection