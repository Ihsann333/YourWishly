@extends('layouts.app')

@section('title', 'YourWishly - Platform Ucapan dan Pesan Digital')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-50 pt-16 pb-20 lg:pt-24 lg:pb-28">
    <div class="absolute top-0 right-0 -z-10 h-[500px] w-[500px] rounded-full bg-rose-200/40 blur-3xl"></div>
    <div class="absolute bottom-10 left-10 -z-10 h-[400px] w-[400px] rounded-full bg-amber-100/50 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
            
            <!-- Hero Left: Text Content -->
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100/50 mb-6">
                    <span>🎉 Baru! Bagikan Momen Indah Anda</span>
                </span>
                
                <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                    <span class="block">Sampaikan ucapan spesial</span>
                    <span class="block bg-gradient-to-r from-rose-500 via-pink-500 to-amber-500 bg-clip-text text-transparent mt-2">
                        dengan cara berkesan.
                    </span>
                </h1>
                
                <p class="mt-4 text-base text-slate-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl leading-relaxed">
                    YourWishly memudahkan Anda membuat kartu ucapan digital yang interaktif. Kumpulkan doa, pesan manis, dan foto dari teman-teman dalam satu galeri eksklusif yang bisa disimpan selamanya.
                </p>

                <div class="mt-8 sm:max-w-lg sm:mx-auto lg:mx-0 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 cursor-pointer">
                            Masuk Ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 cursor-pointer">
                            Mulai Buat Kartu
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto text-center bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold px-8 py-4 rounded-2xl shadow-sm hover:shadow transition-all cursor-pointer">
                            Saya Sudah Ada Akun
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Hero Right: Carousel Preview -->
            <div class="mt-12 sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 flex justify-center">
                <div class="relative w-full max-w-[440px]" data-yourwishly-carousel="hero" aria-label="Carousel contoh kartu Wishly">
                    <div class="absolute -top-4 -right-4 w-full h-full bg-gradient-to-tr from-amber-500 to-rose-400 rounded-3xl opacity-20 transform rotate-3"></div>
                    <div class="absolute -bottom-4 -left-4 w-full h-full bg-gradient-to-tr from-indigo-500 to-blue-400 rounded-3xl opacity-10 transform -rotate-3"></div>

                    <div class="relative overflow-hidden backdrop-blur-md bg-white/95 rounded-3xl border border-slate-100 shadow-xl">
                        <div class="carousel-viewport">
                            <div class="carousel-track flex transition-transform duration-700 ease-in-out">
                                <div class="carousel-slide min-w-full p-8">
                                    <div class="rounded-3xl bg-gradient-to-br from-blue-900 via-indigo-900 to-cyan-900 text-white p-6 shadow-lg">
                                        <div class="flex items-center space-x-3 mb-5">
                                            <span class="text-4xl">🎓</span>
                                            <div>
                                                <h3 class="font-extrabold text-lg">Selamat Wisuda, Ihsan!</h3>
                                                <p class="text-white/70 text-xs">Template: Wisuda</p>
                                            </div>
                                        </div>
                                        <p class="text-white/85 text-sm italic mb-6 leading-relaxed">
                                            "Selamat atas kelulusannya ya! Semoga langkah selanjutnya penuh keberkahan dan sukses selalu."
                                        </p>
                                        <div class="grid grid-cols-3 gap-3 text-center text-white">
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">12</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Ucapan</span>
                                            </div>
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">3</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Foto</span>
                                            </div>
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">QR</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Bagikan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-slide min-w-full p-8">
                                    <div class="rounded-3xl bg-gradient-to-br from-pink-500 via-rose-500 to-amber-400 text-white p-6 shadow-lg">
                                        <div class="flex items-center space-x-3 mb-5">
                                            <span class="text-4xl">🎂</span>
                                            <div>
                                                <h3 class="font-extrabold text-lg">Happy Birthday, Cici!</h3>
                                                <p class="text-white/70 text-xs">Template: Ulang Tahun</p>
                                            </div>
                                        </div>
                                        <p class="text-white/85 text-sm italic mb-6 leading-relaxed">
                                            "Semoga sehat, bahagia, dan semua harapanmu tahun ini tercapai. Jangan lupa traktir!"
                                        </p>
                                        <div class="grid grid-cols-3 gap-3 text-center text-white">
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">20</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Ucapan</span>
                                            </div>
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">8</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Foto</span>
                                            </div>
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">LIVE</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Aktif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-slide min-w-full p-8">
                                    <div class="rounded-3xl bg-gradient-to-br from-emerald-800 via-green-800 to-emerald-950 text-white p-6 shadow-lg">
                                        <div class="flex items-center space-x-3 mb-5">
                                            <span class="text-4xl">🌙</span>
                                            <div>
                                                <h3 class="font-extrabold text-lg">Selamat Hari Raya</h3>
                                                <p class="text-white/70 text-xs">Template: Hari Raya</p>
                                            </div>
                                        </div>
                                        <p class="text-white/85 text-sm italic mb-6 leading-relaxed">
                                            "Mohon maaf lahir dan batin. Semoga kebersamaan dan keberkahan selalu menyertai."
                                        </p>
                                        <div class="grid grid-cols-3 gap-3 text-center text-white">
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">15</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Ucapan</span>
                                            </div>
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">5</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Foto</span>
                                            </div>
                                            <div class="rounded-2xl bg-white/10 p-3">
                                                <span class="block text-lg font-black">QR</span>
                                                <span class="block text-[10px] uppercase tracking-wider text-white/70">Scan</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4 px-6 pb-6">
                            <button type="button" class="carousel-prev inline-flex items-center justify-center h-11 w-11 rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 transition-colors" aria-label="Sebelumnya">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <div class="carousel-dots flex items-center gap-2" aria-label="Navigasi carousel">
                                <button type="button" class="carousel-dot h-2.5 w-2.5 rounded-full bg-slate-300 transition-all" aria-label="Slide 1"></button>
                                <button type="button" class="carousel-dot h-2.5 w-2.5 rounded-full bg-slate-300 transition-all" aria-label="Slide 2"></button>
                                <button type="button" class="carousel-dot h-2.5 w-2.5 rounded-full bg-slate-300 transition-all" aria-label="Slide 3"></button>
                            </div>

                            <button type="button" class="carousel-next inline-flex items-center justify-center h-11 w-11 rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 transition-colors" aria-label="Berikutnya">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white border-y border-slate-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <span class="block text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">{{ $totalCards }}</span>
                <span class="block text-slate-400 text-xs sm:text-sm font-semibold mt-1 uppercase tracking-wider">Kartu Dibuat</span>
            </div>
            <div>
                <span class="block text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">{{ $totalGreetings }}</span>
                <span class="block text-slate-400 text-xs sm:text-sm font-semibold mt-1 uppercase tracking-wider">Ucapan Terkirim</span>
            </div>
            <div>
                <span class="block text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">6+</span>
                <span class="block text-slate-400 text-xs sm:text-sm font-semibold mt-1 uppercase tracking-wider">Desain Kategori</span>
            </div>
            <div>
                <span class="block text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">100%</span>
                <span class="block text-slate-400 text-xs sm:text-sm font-semibold mt-1 uppercase tracking-wider">Gratis & Cepat</span>
            </div>
        </div>
    </div>
</div>

<!-- How it works -->
<div class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">Cara Kerja YourWishly</h2>
            <p class="mt-4 text-slate-500 sm:text-lg">Hanya butuh 3 langkah mudah untuk mengumpulkan ucapan manis dari orang-orang tersayang.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col items-center text-center transform transition-transform hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-3xl mb-6 font-bold">1</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Buat Kartu Ucapan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pilih kategori acara (Wisuda, Ulang Tahun, Pernikahan) dan pilih template desain premium yang Anda sukai.
                </p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col items-center text-center transform transition-transform hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-pink-50 text-pink-500 flex items-center justify-center text-3xl mb-6 font-bold">2</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Bagikan Tautan Unik</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Sistem akan membuatkan link unik instan. Salin link tersebut dan bagikan ke WhatsApp, Instagram, atau grup keluarga.
                </p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col items-center text-center transform transition-transform hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-3xl mb-6 font-bold">3</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Lihat Galeri Ucapan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Tamu/pengunjung mengirimkan doa dan foto langsung melalui link Anda. Semuanya akan tersaji rapi dalam galeri estetik!
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Banner -->
<div class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative" data-yourwishly-carousel="promo" aria-label="Carousel promo Wishly">
            <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-rose-500/10 blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-48 h-48 rounded-full bg-amber-500/10 blur-2xl"></div>

            <div class="relative overflow-hidden rounded-[36px] shadow-2xl border border-slate-100 bg-gradient-to-br from-rose-500 via-pink-500 to-amber-500 text-white">
                <div class="carousel-viewport">
                    <div class="carousel-track flex transition-transform duration-700 ease-in-out">
                        <div class="carousel-slide min-w-full p-10 sm:p-16 text-center">
                            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Siap Membuat Momen Spesial Tak Terlupakan?</h2>
                            <p class="text-white/80 max-w-2xl mx-auto text-base sm:text-lg">
                                Daftar sekarang secara gratis dan buat kartu ucapan pertamamu dalam hitungan detik.
                            </p>
                        </div>

                        <div class="carousel-slide min-w-full p-10 sm:p-16 text-center">
                            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">QR Code, Foto, dan Ucapan dalam Satu Kartu</h2>
                            <p class="text-white/80 max-w-2xl mx-auto text-base sm:text-lg">
                                Bagikan link unik agar teman dan keluarga bisa kirim pesan plus foto langsung dari halaman kartu.
                            </p>
                        </div>

                        <div class="carousel-slide min-w-full p-10 sm:p-16 text-center">
                            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Buat Galeri Ucapan yang Terlihat Premium</h2>
                            <p class="text-white/80 max-w-2xl mx-auto text-base sm:text-lg">
                                Tampilan estetik, responsif, dan siap di-print ke PDF untuk disimpan sebagai kenangan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-8 sm:px-10 sm:pb-10">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="carousel-prev inline-flex items-center justify-center h-11 w-11 rounded-full border border-white/25 bg-white/10 text-white shadow-sm hover:bg-white/20 transition-colors" aria-label="Sebelumnya">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <div class="carousel-dots flex items-center gap-2" aria-label="Navigasi promo carousel">
                                <button type="button" class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/40 transition-all" aria-label="Slide 1"></button>
                                <button type="button" class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/40 transition-all" aria-label="Slide 2"></button>
                                <button type="button" class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/40 transition-all" aria-label="Slide 3"></button>
                            </div>

                            <button type="button" class="carousel-next inline-flex items-center justify-center h-11 w-11 rounded-full border border-white/25 bg-white/10 text-white shadow-sm hover:bg-white/20 transition-colors" aria-label="Berikutnya">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <div class="text-center sm:text-right">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-block bg-white text-rose-600 hover:bg-slate-50 font-bold px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 cursor-pointer">
                                    Kembali Ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-block bg-white text-rose-600 hover:bg-slate-50 font-bold px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 cursor-pointer">
                                    Mulai Gratis Sekarang
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
