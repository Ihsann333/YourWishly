@extends('layouts.app')

@section('title', 'Daftar Akun - YourWishly')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 relative">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 h-[500px] w-[500px] rounded-full bg-rose-100/30 blur-3xl"></div>
    <div class="absolute bottom-10 left-10 -z-10 h-[300px] w-[300px] rounded-full bg-amber-50/50 blur-3xl"></div>

    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-[32px] border border-slate-100 shadow-xl">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-slate-900">Daftar Akun Baru</h2>
            <p class="mt-2 text-sm text-slate-500">
                Mulailah membuat kartu ucapan digital yang indah hari ini.
            </p>
        </div>

        <form class="mt-8 space-y-5" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" 
                        class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all @error('name') border-rose-350 bg-rose-50/20 @enderror" 
                        placeholder="Nama Lengkap Anda">
                    @error('name')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" 
                        class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all @error('email') border-rose-350 bg-rose-50/20 @enderror" 
                        placeholder="contoh@domain.com">
                    @error('email')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-4 py-3 pr-24 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all @error('password') border-rose-350 bg-rose-50/20 @enderror"
                            placeholder="Minimal 6 karakter">
                        <button type="button" data-password-toggle="password" data-show-label="Lihat" data-hide-label="Sembunyikan" aria-pressed="false"
                            class="absolute inset-y-1.5 right-1.5 rounded-lg px-3 text-xs font-bold text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition-colors cursor-pointer">
                            Lihat
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="appearance-none block w-full px-4 py-3 pr-24 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Ulangi password Anda">
                        <button type="button" data-password-toggle="password_confirmation" data-show-label="Lihat" data-hide-label="Sembunyikan" aria-pressed="false"
                            class="absolute inset-y-1.5 right-1.5 rounded-lg px-3 text-xs font-bold text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition-colors cursor-pointer">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-rose-500 hover:text-rose-600 transition-colors">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
