<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'YourWishly - Sampaikan ucapan spesial dengan cara yang lebih berkesan')</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col selection:bg-rose-500 selection:text-white">

    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 backdrop-blur-md bg-white/75 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">YourWishly</span>
                        <span class="hidden sm:inline-block text-xs font-semibold px-2 py-0.5 bg-rose-50 text-rose-600 rounded-full border border-rose-100">Digital Cards</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-slate-600 hover:text-rose-500 font-medium transition-colors">Beranda</a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-rose-500 font-medium transition-colors">Admin Panel</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-rose-500 font-medium transition-colors">Dashboard</a>
                        
                        <div class="flex items-center space-x-4 border-l border-slate-200 pl-6">
                            <span class="text-slate-700 font-medium">Hai, <strong class="font-semibold">{{ auth()->user()->name }}</strong></span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-rose-200 transition-all font-semibold cursor-pointer">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-rose-500 font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="text-slate-500 hover:text-slate-700 focus:outline-none cursor-pointer">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 border-b border-slate-100 backdrop-blur-md">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-50 hover:text-rose-500 font-medium">Beranda</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-50 hover:text-rose-500 font-medium">Admin Panel</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-50 hover:text-rose-500 font-medium">Dashboard</a>
                    <div class="border-t border-slate-100 my-2 pt-2 px-3">
                        <span class="block text-slate-500 text-sm mb-2">Hai, <strong class="text-slate-700 font-semibold">{{ auth()->user()->name }}</strong></span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-center bg-rose-50 text-rose-600 px-4 py-2 rounded-xl font-semibold hover:bg-rose-100 transition-colors cursor-pointer">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-50 hover:text-rose-500 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-center bg-gradient-to-r from-rose-500 to-amber-500 text-white font-semibold px-4 py-2.5 rounded-xl mx-3 my-2 transition-all">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Alerts container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div id="success-alert" class="flex items-center p-4 mb-4 text-emerald-800 border border-emerald-100 rounded-2xl bg-emerald-50/70 backdrop-blur-md shadow-sm transition-all duration-300">
                <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Success</span>
                <div class="ml-3 text-sm font-semibold">
                    {{ session('success') }}
                </div>
                <button type="button" onclick="document.getElementById('success-alert').remove()" class="ml-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex items-center justify-center h-8 w-8 cursor-pointer">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="error-alert" class="flex items-center p-4 mb-4 text-rose-800 border border-rose-100 rounded-2xl bg-rose-50/70 backdrop-blur-md shadow-sm transition-all duration-300">
                <svg class="flex-shrink-0 w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4H9V5h2v6Z"/>
                </svg>
                <span class="sr-only">Error</span>
                <div class="ml-3 text-sm font-semibold">
                    {{ session('error') }}
                </div>
                <button type="button" onclick="document.getElementById('error-alert').remove()" class="ml-auto -mx-1.5 -my-1.5 bg-rose-50 text-rose-500 rounded-lg focus:ring-2 focus:ring-rose-400 p-1.5 hover:bg-rose-200 inline-flex items-center justify-center h-8 w-8 cursor-pointer">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 mt-20 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
                <div>
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">YourWishly</a>
                    <p class="text-slate-400 text-sm mt-1">Sampaikan ucapan spesial dengan cara yang lebih berkesan.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="text-slate-400 hover:text-rose-500 transition-colors text-sm font-medium">Tentang</a>
                    <a href="#" class="text-slate-400 hover:text-rose-500 transition-colors text-sm font-medium">Syarat & Ketentuan</a>
                    <a href="#" class="text-slate-400 hover:text-rose-500 transition-colors text-sm font-medium">Bantuan</a>
                </div>
                <div>
                    <p class="text-slate-400 text-xs">&copy; {{ date('Y') }} YourWishly. Seluruh hak cipta dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
