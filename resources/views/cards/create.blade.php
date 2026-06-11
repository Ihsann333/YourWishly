@extends('layouts.app')

@section('title', 'Buat Kartu Baru - YourWishly')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative">
    <div class="absolute top-10 right-10 -z-10 h-72 w-72 rounded-full bg-rose-100/30 blur-3xl"></div>
    <div class="absolute bottom-10 left-10 -z-10 h-72 w-72 rounded-full bg-amber-100/30 blur-3xl"></div>

    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-rose-500 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Dashboard
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-2">Buat Kartu Ucapan Baru</h1>
        <p class="text-slate-500 text-sm">Isi detail di bawah untuk membuat halaman kartu ucapan digital Anda sendiri.</p>
    </div>

    <form action="{{ route('cards.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Card settings panel -->
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm space-y-6">
            <h2 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-4">1. Detail Kartu</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recipient Name -->
                <div>
                    <label for="recipient_name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Penerima <span class="text-rose-500">*</span></label>
                    <input type="text" id="recipient_name" name="recipient_name" required value="{{ old('recipient_name') }}"
                        class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                        placeholder="Contoh: Nur Ihsan">
                    @error('recipient_name')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sender Name -->
                <div>
                    <label for="sender_name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Pengirim <span class="text-rose-500">*</span></label>
                    <input type="text" id="sender_name" name="sender_name" required value="{{ old('sender_name') }}"
                        class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                        placeholder="Contoh: Dari Kak Rani, Teman Kelas, atau bebas">
                    <p class="text-[10px] text-slate-400 mt-1">Nama ini bebas, tidak harus sama dengan nama akun.</p>
                    @error('sender_name')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Type -->
                <div>
                    <label for="event_type" class="block text-sm font-bold text-slate-700 mb-1.5">Jenis Acara <span class="text-rose-500">*</span></label>
                    <select id="event_type" name="event_type" required
                        class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all bg-white">
                        <option value="" disabled selected>Pilih jenis acara</option>
                        <option value="Ulang Tahun" {{ old('event_type') == 'Ulang Tahun' ? 'selected' : '' }}>Ulang Tahun 🎂</option>
                        <option value="Wisuda" {{ old('event_type') == 'Wisuda' ? 'selected' : '' }}>Wisuda 🎓</option>
                        <option value="Pernikahan" {{ old('event_type') == 'Pernikahan' ? 'selected' : '' }}>Pernikahan 💍</option>
                        <option value="Hari Raya" {{ old('event_type') == 'Hari Raya' ? 'selected' : '' }}>Hari Raya 🌙</option>
                        <option value="Anniversary" {{ old('event_type') == 'Anniversary' ? 'selected' : '' }}>Anniversary ❤️</option>
                        <option value="Perpisahan" {{ old('event_type') == 'Perpisahan' ? 'selected' : '' }}>Perpisahan 👋</option>
                    </select>
                    @error('event_type')
                        <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-1.5">Judul Kartu <span class="text-rose-500">*</span></label>
                <input type="text" id="title" name="title" required value="{{ old('title') }}"
                    class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                    placeholder="Contoh: Selamat Wisuda, Nur Ihsan! 🎓">
                @error('title')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description / Pesan Pembuka -->
            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 mb-1.5">Pesan Pembuka (Opsional)</label>
                <textarea id="description" name="description" rows="4"
                    class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                    placeholder="Tulis kalimat pembuka singkat sebelum kartu dibuka.">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Card Body / Isi Kartu -->
            <div>
                <label for="body" class="block text-sm font-bold text-slate-700 mb-1.5">Isi Kartu <span class="text-rose-500">*</span></label>
                <textarea id="body" name="body" rows="7" required
                    class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all @error('body') border-rose-350 bg-rose-50/20 @enderror"
                    placeholder="Tulis isi utama kartu di sini: ucapan, doa, cerita singkat, detail acara, atau pesan spesial untuk penerima.">{{ old('body') }}</textarea>
                <p class="text-[10px] text-slate-400 mt-1">Bagian ini akan muncul setelah penerima menekan tombol buka kartu.</p>
                @error('body')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div>
                <label for="photo" class="block text-sm font-bold text-slate-700 mb-1.5">Foto Kartu (Opsional)</label>
                <input type="file" id="photo" name="photo" accept="image/*"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 transition-all cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 3MB. Rekomendasi rasio 4:3 atau 1:1 supaya foto pas di kartu dan tidak ikut ukuran asli foto.</p>
                @error('photo')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Countdown Date -->
            <div>
                <label for="countdown_date" class="block text-sm font-bold text-slate-700 mb-1.5">Tanggal Acara / Countdown (Opsional)</label>
                <input type="datetime-local" id="countdown_date" name="countdown_date" value="{{ old('countdown_date') }}"
                    class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all">
                <p class="text-[10px] text-slate-400 mt-1">Gunakan ini untuk menampilkan penghitung mundur waktu acara pada kartu.</p>
                @error('countdown_date')
                    <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Template selection panel -->
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm space-y-6">
            <h2 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-4">2. Pilih Template Desain</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($templates as $template)
                    <label class="relative block cursor-pointer group">
                        <input type="radio" name="template_id" value="{{ $template->id }}" class="sr-only peer" 
                            {{ (old('template_id') == $template->id || $loop->first) ? 'checked' : '' }}>
                        
                        <!-- Design card preview template -->
                        <div class="h-40 rounded-2xl p-5 flex flex-col justify-between border-2 border-slate-150 peer-checked:border-rose-500 peer-checked:ring-2 peer-checked:ring-rose-500/20 transition-all shadow-sm hover:shadow-md {{ $template->theme_class }} {{ $template->text_color }}">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">{{ $template->emoji }}</span>
                                <!-- Selected indicator -->
                                <span class="opacity-0 peer-checked:opacity-100 bg-white text-rose-600 rounded-full p-1 border border-rose-100 shadow-sm transition-opacity inline-flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </div>
                            <div>
                                <span class="block font-black text-lg tracking-tight">{{ $template->name }}</span>
                                <span class="block text-xs opacity-75">Gaya Desain</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
            @error('template_id')
                <p class="mt-1 text-xs font-semibold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold px-6 py-3.5 rounded-xl text-sm transition-all cursor-pointer">
                Batalkan
            </a>
            <button type="submit" class="bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-bold px-8 py-3.5 rounded-xl text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                Buat Kartu Ucapan
            </button>
        </div>
    </form>
</div>
@endsection
