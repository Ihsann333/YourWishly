@php
    $isOwnerOrAdmin = auth()->check() && (auth()->id() === $card->user_id || auth()->user()->role === 'admin');
    $isLocked = $card->isLocked();
    $showContent = !$isLocked || $isOwnerOrAdmin;
    $openingLine = $card->description ?: "Untuk {$card->recipient_name}, semoga kartu ini membawa hangat, doa baik, dan senyum kecil yang tulus.";
    $cardBody = $card->body ?: 'Isi kartu belum ditambahkan. Pemilik kartu dapat mengisinya lewat halaman edit kartu.';
    $cardEmoji = $card->template->emoji ?? '✉️';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $card->title }} - YourWishly</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .print-sheet { display: none; }
        .reveal-content { display: none; }
        body.card-revealed .reveal-content { display: block; }
        body.card-revealed .opening-panel { display: none; }
        .card-media {
            display: block;
            width: 100%;
            height: auto;
            object-fit: cover;
            aspect-ratio: 4 / 3;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {
            html, body {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                color: #0f172a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                width: 100% !important;
                height: 100% !important;
                overflow: hidden !important;
            }

            body > :not(.print-sheet) { display: none !important; }

            .print-sheet {
                display: block !important;
                width: 100% !important;
                height: 100% !important;
                position: fixed !important;
                inset: 0 !important;
            }

            .no-print { display: none !important; }

            .print-sheet-wrapper {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 10mm !important;
                min-height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .print-card {
                width: 100% !important;
                max-width: 190mm !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                background: transparent !important;
                color: inherit !important;
                break-inside: avoid;
                page-break-inside: avoid;
                border-radius: 24px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-card *,
            .print-card *::before,
            .print-card *::after {
                animation: none !important;
                transition: none !important;
            }

            .print-card [class*="backdrop-blur"] { backdrop-filter: none !important; }
            .print-card img,
            .print-sheet img { max-width: 100% !important; }

            .print-photo { max-height: 68mm !important; }
            .print-photo img {
                height: auto !important;
                max-height: 68mm !important;
            }

            .print-emblem {
                width: 20mm !important;
                height: 20mm !important;
                font-size: 12mm !important;
                margin-bottom: 4mm !important;
            }

            .print-title {
                font-size: 24pt !important;
                line-height: 1.15 !important;
            }

            .print-desc {
                font-size: 11pt !important;
                line-height: 1.6 !important;
                max-width: none !important;
            }

            .print-meta { font-size: 9pt !important; }
            .print-countdown { display: none !important; }
            .opening-panel { display: none !important; }
            .reveal-content { display: block !important; }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col pb-12">
    <div class="no-print w-full py-4 px-6 flex justify-between items-center backdrop-blur-md bg-white/70 border-b border-slate-100 sticky top-0 z-40">
        <a href="{{ route('home') }}" class="flex items-center space-x-1.5">
            <span class="text-xl font-extrabold bg-gradient-to-r from-rose-500 to-amber-500 bg-clip-text text-transparent">YourWishly</span>
        </a>
        <div class="flex items-center space-x-3">
            @if($isLocked)
                <button type="button" disabled class="bg-slate-100 text-slate-400 border border-slate-200 text-xs font-bold px-3.5 py-2 rounded-xl transition-all shadow-sm flex items-center space-x-1.5 cursor-not-allowed">
                    <span>Kartu terkunci</span>
                </button>
            @else
                <button onclick="window.print()" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold px-3.5 py-2 rounded-xl transition-all shadow-sm flex items-center space-x-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak / Simpan PDF</span>
                </button>
            @endif
            @auth
                <a href="{{ route('dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-xl transition-all">
                    Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-rose-500 to-amber-500 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition-all">
                    Buat Kartu
                </a>
            @endauth
        </div>
        @unless($isLocked)
            <p class="no-print mt-2 text-[11px] text-slate-400 text-right">
                Saat menyimpan PDF, matikan <strong>Headers and footers</strong> dan aktifkan <strong>Background graphics</strong> agar warna kartu ikut tercetak.
            </p>
        @endunless
    </div>

    <div class="no-print max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div id="success-alert" class="flex items-center p-4 text-emerald-800 border border-emerald-100 rounded-2xl bg-emerald-50/70 backdrop-blur-md shadow-sm">
                <div class="text-sm font-semibold">{{ session('success') }}</div>
                <button type="button" onclick="document.getElementById('success-alert').remove()" class="ml-auto text-emerald-500 hover:text-emerald-700 cursor-pointer">
                    &times;
                </button>
            </div>
        @endif
        @if(session('error'))
            <div id="error-alert" class="flex items-center p-4 text-rose-800 border border-rose-100 rounded-2xl bg-rose-50/70 backdrop-blur-md shadow-sm">
                <div class="text-sm font-semibold">{{ session('error') }}</div>
                <button type="button" onclick="document.getElementById('error-alert').remove()" class="ml-auto text-rose-500 hover:text-rose-700 cursor-pointer">
                    &times;
                </button>
            </div>
        @endif
    </div>

    <section class="opening-panel no-print max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
        <div class="relative overflow-hidden rounded-[36px] bg-white border border-slate-100 shadow-xl p-6 sm:p-10 lg:p-12">
            <div class="absolute -top-16 -right-10 h-48 w-48 rounded-full bg-rose-100 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-8 h-56 w-56 rounded-full bg-amber-100 blur-3xl"></div>

            <div class="relative z-10 grid gap-8 lg:grid-cols-[1.15fr_0.85fr] items-center">
                <div class="space-y-5 max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[10px] font-black uppercase tracking-[0.28em] text-slate-600">
                            Pesan pembuka
                        </span>
                        <span class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-rose-600 border border-rose-100">
                            YourWishly Card {{ $isLocked ? '🔒' : '✉️' }}
                        </span>
                    </div>

                    <p class="text-sm sm:text-base font-semibold uppercase tracking-[0.24em] text-slate-500">
                        Untuk: <span class="text-slate-900 font-extrabold">{{ $card->recipient_name }}</span>
                        <span class="mx-2 text-slate-350">|</span>
                        Dari: <span class="text-slate-900 font-extrabold">{{ $card->sender_name }}</span>
                    </p>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[0.95] text-slate-900">
                        {{ $card->title }}
                    </h1>
                    <p class="text-sm sm:text-base lg:text-lg text-slate-600 max-w-xl leading-relaxed">
                        {{ $openingLine }}
                    </p>
                    <p class="text-sm sm:text-base text-slate-500 max-w-xl leading-relaxed">
                        @if($isLocked)
                            Kartu ini masih menunggu waktu yang sudah ditentukan. Isi kartu dan buku ucapan akan terbuka otomatis setelah hitungan mundur selesai.
                        @else
                            Buka dulu pesan pembukanya. Setelah itu, kartu ucapannya akan muncul dan kamu bisa lanjut baca isi lengkapnya.
                        @endif
                    </p>

                    <div class="flex flex-wrap gap-3 pt-1">
                        @if($isLocked && !$isOwnerOrAdmin)
                            <button type="button" disabled class="inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-bold bg-slate-200 text-slate-500 border border-slate-200 cursor-not-allowed">
                                Kartu belum bisa dibuka
                            </button>
                            <span class="inline-flex items-center justify-center rounded-2xl bg-rose-50 px-5 py-3 text-sm font-bold border border-rose-100 text-rose-600">
                                Tunggu countdown selesai
                            </span>
                        @else
                            <button id="open-card-btn" type="button" class="inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-bold transition-transform hover:-translate-y-0.5 cursor-pointer" style="background:#0f172a;color:#ffffff;border:1px solid #0f172a;box-shadow:0 10px 25px rgba(15,23,42,.12);">
                                Buka kartu ucapan
                            </button>
                            @if($isLocked && $isOwnerOrAdmin)
                                <span class="inline-flex items-center justify-center rounded-2xl bg-amber-50 px-5 py-3 text-sm font-bold border border-amber-100 text-amber-600">
                                    Mode Pratinjau
                                </span>
                            @else
                                <a href="#write-greeting" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-bold border border-slate-200 text-slate-700 transition-transform hover:-translate-y-0.5">
                                    Langsung ke ucapan
                                </a>
                            @endif
                        @endif
                    </div>

                    @if($isLocked && $card->countdown_date)
                        <div class="rounded-[28px] border border-rose-100 bg-rose-50/70 p-4 sm:p-5">
                            <p class="text-[10px] font-black uppercase tracking-[0.26em] text-rose-400">Kartu terbuka dalam</p>
                            <div class="mt-3 grid grid-cols-4 gap-2 text-center" id="countdown-container" data-target="{{ $card->countdown_date->toIso8601String() }}">
                                <div class="rounded-2xl bg-white border border-rose-100 p-2.5">
                                    <span class="block text-xl sm:text-2xl font-black text-slate-900" id="days">00</span>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-500">Hari</span>
                                </div>
                                <div class="rounded-2xl bg-white border border-rose-100 p-2.5">
                                    <span class="block text-xl sm:text-2xl font-black text-slate-900" id="hours">00</span>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-500">Jam</span>
                                </div>
                                <div class="rounded-2xl bg-white border border-rose-100 p-2.5">
                                    <span class="block text-xl sm:text-2xl font-black text-slate-900" id="minutes">00</span>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-500">Menit</span>
                                </div>
                                <div class="rounded-2xl bg-white border border-rose-100 p-2.5">
                                    <span class="block text-xl sm:text-2xl font-black text-slate-900" id="seconds">00</span>
                                    <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-500">Detik</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="relative">
                    <div class="rounded-[32px] border border-slate-200 bg-white shadow-2xl overflow-hidden">
                        <div class="relative h-[320px] sm:h-[420px] flex flex-col items-center justify-center px-8 text-center bg-gradient-to-br from-slate-50 to-white">
                            <div class="absolute inset-x-8 top-8 rounded-3xl border border-slate-100 bg-white/75 p-4 shadow-sm">
                                <span class="block text-[10px] uppercase tracking-[0.28em] font-black text-slate-400">Preview kartu</span>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                    @if($isLocked)
                                        Isi kartu masih terkunci sampai waktu yang ditentukan.
                                    @else
                                        Tampilan ini hanya pembuka. Isi kartu akan muncul setelah tombol dibuka.
                                    @endif
                                </p>
                            </div>
                            <div class="w-28 h-28 rounded-full bg-white flex items-center justify-center text-5xl mt-16 mb-5 shadow-inner border border-slate-100">
                                {{ $isLocked ? '🔒' : '✉️' }}
                            </div>
                            <p class="text-lg font-black tracking-tight text-slate-900">{{ $card->title }}</p>
                            <p class="mt-2 text-sm text-slate-600 max-w-xs leading-relaxed">
                                @if($isLocked)
                                    Hitungan mundur sedang berjalan. Kartu akan bisa dibuka setelah waktunya tiba.
                                @else
                                    Klik tombol untuk membuka kartu dan melihat isi lengkapnya.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($showContent)
    <div id="card-flow" class="reveal-content print-sheet-wrapper max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6 space-y-10">
        <section id="card-cover" class="relative overflow-hidden rounded-[36px] border border-white/30 shadow-[0_20px_60px_rgba(15,23,42,0.12)] {{ $card->template->theme_class ?? 'bg-gradient-to-br from-slate-100 to-slate-250' }} {{ $card->template->text_color ?? 'text-slate-800' }}">
            <div class="absolute inset-0 bg-white/10"></div>
            <div class="absolute -top-16 -right-10 h-48 w-48 rounded-full bg-white/15 blur-2xl"></div>
            <div class="absolute -bottom-20 -left-8 h-56 w-56 rounded-full bg-black/5 blur-3xl"></div>

            <div class="relative z-10 grid gap-8 lg:grid-cols-[1.2fr_0.9fr] p-6 sm:p-10 lg:p-12 items-center">
                <div class="space-y-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-black/10 px-3 py-1 text-[10px] font-black uppercase tracking-[0.28em]">
                            Cover Pembuka
                        </span>
                        <span class="inline-flex items-center rounded-full bg-black/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
                            {{ $card->event_type }}
                        </span>
                    </div>

                    <div class="space-y-4 max-w-2xl">
                        <p class="text-sm sm:text-base font-semibold uppercase tracking-[0.24em] opacity-80">
                            Untuk {{ $card->recipient_name }}
                        </p>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[0.95]">
                            {{ $openingLine }}
                        </h1>
                        <p class="text-sm sm:text-base lg:text-lg opacity-90 max-w-xl leading-relaxed">
                            Halaman ini disusun seperti cerita: cover pembuka dulu, lalu isi kartu, dan setelah itu ruang untuk mengirim ucapan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="#card-content" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 text-white px-5 py-3 text-sm font-bold shadow-lg shadow-slate-950/10 transition-transform hover:-translate-y-0.5">
                            Baca isi kartu
                        </a>
                        <a href="#write-greeting" class="inline-flex items-center justify-center rounded-2xl bg-white/25 px-5 py-3 text-sm font-bold border border-white/30 backdrop-blur-md transition-transform hover:-translate-y-0.5">
                            Lanjut ke ucapan
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="rounded-2xl bg-white/20 backdrop-blur-md border border-white/25 p-3">
                            <span class="block text-[10px] uppercase font-black tracking-widest opacity-70">Judul</span>
                            <span class="block mt-1 text-sm font-bold leading-snug">{{ $card->title }}</span>
                        </div>
                        <div class="rounded-2xl bg-white/20 backdrop-blur-md border border-white/25 p-3">
                            <span class="block text-[10px] uppercase font-black tracking-widest opacity-70">Penerima</span>
                            <span class="block mt-1 text-sm font-bold leading-snug">{{ $card->recipient_name }}</span>
                        </div>
                        <div class="rounded-2xl bg-white/20 backdrop-blur-md border border-white/25 p-3">
                            <span class="block text-[10px] uppercase font-black tracking-widest opacity-70">Tema</span>
                            <span class="block mt-1 text-sm font-bold leading-snug">{{ $card->template->name ?? 'Default' }}</span>
                        </div>
                        <div class="rounded-2xl bg-white/20 backdrop-blur-md border border-white/25 p-3">
                            <span class="block text-[10px] uppercase font-black tracking-widest opacity-70">Ucapan</span>
                            <span class="block mt-1 text-sm font-bold leading-snug">{{ $card->greetings->count() }} masuk</span>
                        </div>
                    </div>

                    @if($card->countdown_date && $card->countdown_date->isFuture() && $isOwnerOrAdmin)
                        <div class="mt-2 px-4 py-2 bg-yellow-500/10 backdrop-blur-md rounded-2xl border border-yellow-500/20 text-xs font-bold uppercase tracking-wider text-yellow-700 inline-flex items-center space-x-1">
                            <span>Mode pratinjau: halaman ini terkunci untuk pengunjung umum sampai waktunya tiba.</span>
                        </div>
                    @endif
                </div>

                <div class="relative">
                    <div class="rounded-[32px] overflow-hidden border border-white/30 bg-white/15 shadow-2xl">
                        @if($card->photo_path)
                            <img src="{{ asset('storage/' . $card->photo_path) }}" alt="Foto kartu {{ $card->recipient_name }}" class="card-media">
                        @else
                            <div class="h-[340px] sm:h-[430px] flex flex-col items-center justify-center px-8 text-center">
                                <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-5xl mb-5 shadow-inner">
                                    {{ $cardEmoji }}
                                </div>
                                <p class="text-lg font-black tracking-tight">{{ $card->title }}</p>
                                <p class="mt-2 text-sm opacity-85 max-w-xs leading-relaxed">
                                    Cover ini jadi pembuka sebelum masuk ke isi kartu dan ucapan dari orang-orang terdekat.
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="absolute -bottom-5 left-5 right-5 rounded-2xl bg-slate-950/85 text-white p-4 shadow-xl backdrop-blur-md">
                        <p class="text-[10px] uppercase tracking-[0.28em] font-black opacity-70">Kalimat pembuka</p>
                        <p class="mt-1 text-sm sm:text-base font-medium leading-relaxed">
                            {{ $openingLine }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="card-content" class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr] items-start">
            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-6 sm:p-8 sticky top-24">
                <div class="flex items-center gap-3 mb-5">
                    <span class="text-3xl">📖</span>
                    <div>
                        <h2 class="font-extrabold text-slate-900 text-xl sm:text-2xl tracking-tight">Isi kartu</h2>
                        <p class="text-slate-500 text-xs sm:text-sm">Bagian ini menjelaskan isi utama kartu, bukan cover pembukanya.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                        <span class="block text-[10px] font-black uppercase tracking-[0.22em] text-slate-400">Apa yang kamu baca di cover</span>
                        <p class="mt-2 text-slate-700 text-sm leading-relaxed">{{ $openingLine }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                        <span class="block text-[10px] font-black uppercase tracking-[0.22em] text-slate-400">Isi kartu</span>
                        <p class="mt-2 text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $cardBody }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-100 p-4">
                            <span class="block text-[10px] uppercase font-black tracking-widest text-slate-400">Penerima</span>
                            <p class="mt-2 text-sm font-bold text-slate-800">{{ $card->recipient_name }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 p-4">
                            <span class="block text-[10px] uppercase font-black tracking-widest text-slate-400">Acara</span>
                            <p class="mt-2 text-sm font-bold text-slate-800">{{ $card->event_type }}</p>
                        </div>
                    </div>
                    @if($card->countdown_date)
                        <div class="rounded-2xl border border-rose-100 bg-rose-50/70 p-4">
                            <span class="block text-[10px] uppercase font-black tracking-widest text-rose-400">Langkah waktu</span>
                            <p class="mt-2 text-sm font-semibold text-rose-700">
                                @if($isLocked)
                                    Kartu ini masih terkunci untuk pengunjung umum sampai waktunya tiba.
                                @else
                                    Hitung mundur di halaman ini sudah aktif sebagai penanda momen utama.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-6 sm:p-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">✨</span>
                            <div>
                                <h2 class="font-extrabold text-slate-900 text-lg sm:text-xl">Langkah berikutnya</h2>
                                <p class="text-slate-500 text-xs sm:text-sm">Setelah baca cover dan isi kartu, lanjutkan ke ucapan.</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 bg-slate-100 text-slate-600 rounded-full">Alur 3 langkah</span>
                    </div>

                    <div class="grid gap-3 md:grid-cols-3">
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white text-xs font-black">1</span>
                            <h3 class="mt-3 font-bold text-slate-800">Baca cover</h3>
                            <p class="mt-1 text-sm text-slate-500 leading-relaxed">Kalimat pembuka memberi nada awal sebelum masuk ke isi kartu.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white text-xs font-black">2</span>
                            <h3 class="mt-3 font-bold text-slate-800">Pahami isi kartu</h3>
                            <p class="mt-1 text-sm text-slate-500 leading-relaxed">Judul, pesan, dan detail acara disusun sebagai inti kartu.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white text-xs font-black">3</span>
                            <h3 class="mt-3 font-bold text-slate-800">Tinggalkan ucapan</h3>
                            <p class="mt-1 text-sm text-slate-500 leading-relaxed">Isi form di bawah agar pesanmu masuk ke buku ucapan digital.</p>
                        </div>
                    </div>
                </div>

                @if($card->countdown_date)
                    <div class="no-print bg-white rounded-[32px] border border-slate-100 shadow-sm p-6 sm:p-8">
                        <div class="flex items-center space-x-3 mb-5">
                            <span class="text-3xl">⏳</span>
                            <div>
                                <h2 class="font-extrabold text-slate-900 text-lg sm:text-xl">Hitung mundur</h2>
                                <p class="text-slate-500 text-xs sm:text-sm">Penanda waktu untuk membuka bagian kartu yang terkunci.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-3 text-center" id="countdown-container" data-target="{{ $card->countdown_date->toIso8601String() }}">
                            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-2.5">
                                <span class="block text-xl sm:text-2xl font-black tracking-tight" id="days">00</span>
                                <span class="block text-[10px] uppercase font-bold tracking-wider opacity-75">Hari</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-2.5">
                                <span class="block text-xl sm:text-2xl font-black tracking-tight" id="hours">00</span>
                                <span class="block text-[10px] uppercase font-bold tracking-wider opacity-75">Jam</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-2.5">
                                <span class="block text-xl sm:text-2xl font-black tracking-tight" id="minutes">00</span>
                                <span class="block text-[10px] uppercase font-bold tracking-wider opacity-75">Menit</span>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-2.5">
                                <span class="block text-xl sm:text-2xl font-black tracking-tight" id="seconds">00</span>
                                <span class="block text-[10px] uppercase font-bold tracking-wider opacity-75">Detik</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section id="write-greeting" class="no-print bg-white rounded-[32px] border border-slate-100 shadow-sm p-6 sm:p-8">
            <div class="flex items-center space-x-3 mb-6">
                <span class="text-3xl">✍️</span>
                <div>
                    <h2 class="font-extrabold text-slate-800 text-lg sm:text-xl">Berikan Ucapan Anda</h2>
                    <p class="text-slate-450 text-xs sm:text-sm">Setelah membaca isi kartu, lanjutkan dengan menulis pesan untuk penerima.</p>
                </div>
            </div>

            <form action="{{ route('greeting.store', $card->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="sender_name" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Anda <span class="text-rose-500">*</span></label>
                        <input type="text" id="sender_name" name="sender_name" required value="{{ old('sender_name') }}"
                            class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Contoh: Rian Hardi">
                    </div>

                    <div>
                        <label for="photo" class="block text-sm font-bold text-slate-700 mb-1.5">Unggah Foto (Opsional)</label>
                        <input type="file" id="photo" name="photo" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100 transition-all cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 3MB. Rekomendasi rasio 4:3 atau 1:1 supaya foto pas di kartu dan tidak melebar / memanjang.</p>
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-bold text-slate-700 mb-1.5">Pesan Ucapan <span class="text-rose-500">*</span></label>
                    <textarea id="message" name="message" rows="4" required
                        class="appearance-none block w-full px-4 py-3 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                        placeholder="Tulis ucapan selamat, harapan, atau doa tulus Anda di sini..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Reaksi Emoji (Opsional)</label>
                    <div class="flex flex-wrap gap-2.5">
                        <input type="hidden" name="emoji_reaction" id="selected_emoji" value="">
                        @foreach(['❤️', '🎉', '🎓', '🎂', '👏', '🙌', '🌟', '🥳', '💪', '🙏'] as $em)
                            <button type="button" onclick="selectEmoji('{{ $em }}', this)"
                                class="emoji-btn w-11 h-11 flex items-center justify-center text-xl bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200 transition-all hover:scale-105 cursor-pointer">
                                {{ $em }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-bold px-6 py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                        Kirim Ucapan Digital
                    </button>
                </div>
            </form>
        </section>

        <section id="greetings" class="space-y-6">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center space-x-2">
                    <span class="text-3xl">📚</span>
                    <h2 class="font-extrabold text-slate-900 text-xl sm:text-2xl tracking-tight">Buku Ucapan Digital</h2>
                </div>
                <span class="text-xs font-bold px-3 py-1 bg-white border border-slate-200 text-slate-600 rounded-full shadow-sm">
                    {{ $card->greetings->count() }} Ucapan Masuk
                </span>
            </div>

            @if($isLocked)
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-16 text-center">
                    <span class="text-5xl block mb-4">🔒</span>
                    <h3 class="font-extrabold text-slate-700 text-lg mb-1">Galeri Ucapan Terkunci</h3>
                    <p class="text-slate-450 text-sm max-w-sm mx-auto">
                        {{ $card->greetings->count() }} ucapan telah terkumpul. Galeri ucapan akan terbuka otomatis setelah hitungan mundur selesai.
                    </p>
                </div>
            @elseif($card->greetings->isEmpty())
                <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-16 text-center">
                    <span class="text-5xl block mb-4">💬</span>
                    <h3 class="font-extrabold text-slate-700 text-lg mb-1">Belum ada ucapan</h3>
                    <p class="text-slate-450 text-sm max-w-sm mx-auto">
                        Jadilah orang pertama yang mengirimkan ucapan selamat dan doa manis di halaman ini!
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="greetings-gallery">
                    @foreach($card->greetings as $greeting)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden group">
                            @if(auth()->check() && (auth()->id() === $card->user_id || auth()->user()->role === 'admin'))
                                <form action="{{ route('greeting.destroy', $greeting->id) }}" method="POST"
                                    class="no-print absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus ucapan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-rose-50 text-rose-600 p-1.5 rounded-lg border border-rose-100 hover:bg-rose-100 cursor-pointer" title="Hapus Ucapan">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-700 uppercase">
                                            {{ substr($greeting->sender_name, 0, 2) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm sm:text-base leading-tight">{{ $greeting->sender_name }}</h4>
                                            <span class="text-[10px] text-slate-400 block mt-0.5">{{ $greeting->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @if($greeting->emoji_reaction)
                                        <span class="text-2xl bg-slate-50 border border-slate-100 rounded-full px-2 py-0.5 shadow-sm">{{ $greeting->emoji_reaction }}</span>
                                    @endif
                                </div>

                                @if($greeting->photo_path)
                                    <div class="mb-4 rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                                        <img src="{{ asset('storage/' . $greeting->photo_path) }}" alt="Foto ucapan {{ $greeting->sender_name }}" class="card-media" style="aspect-ratio: 1 / 1;">
                                    </div>
                                @endif

                                <p class="text-slate-650 text-sm leading-relaxed whitespace-pre-line">
                                    {{ $greeting->message }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <div class="print-sheet">
        <div class="print-sheet-wrapper mx-auto w-full px-0">
            <div class="print-card relative overflow-hidden {{ $card->template->theme_class ?? 'bg-gradient-to-br from-slate-100 to-slate-250' }} {{ $card->template->text_color ?? 'text-slate-800' }}">
                <div class="absolute inset-0 bg-white/5 -z-10"></div>
                <div class="p-10 text-center relative z-10 flex flex-col items-center">
                    @if($card->photo_path)
                        <div class="print-photo mb-6 w-full overflow-hidden rounded-[22px] border border-slate-200 bg-white shadow-sm">
                            <img src="{{ asset('storage/' . $card->photo_path) }}" alt="Foto kartu {{ $card->recipient_name }}" class="w-full h-auto object-cover">
                        </div>
                    @endif

                    <div class="print-emblem w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-4xl mb-5 shadow-inner">
                        {{ $cardEmoji }}
                    </div>

                    <span class="print-meta inline-block text-xs font-black px-3 py-1 bg-black/10 rounded-full uppercase tracking-widest mb-4">
                        {{ $card->event_type }}
                    </span>

                    <h1 class="print-title text-4xl font-black tracking-tight leading-tight max-w-2xl">
                        {{ $card->title }}
                    </h1>

                    <p class="print-desc mt-6 text-base font-medium leading-relaxed italic max-w-2xl whitespace-pre-line">
                        {{ $cardBody }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        const openCardBtn = document.getElementById('open-card-btn');
        const cardFlow = document.getElementById('card-flow');
        if (openCardBtn && cardFlow) {
            openCardBtn.addEventListener('click', () => {
                document.body.classList.add('card-revealed');
                cardFlow.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }

        const container = document.getElementById('countdown-container');
        if (container) {
            const targetStr = container.getAttribute('data-target');
            const targetDate = new Date(targetStr).getTime();

            const daysVal = document.getElementById('days');
            const hoursVal = document.getElementById('hours');
            const minutesVal = document.getElementById('minutes');
            const secondsVal = document.getElementById('seconds');

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    daysVal.textContent = '00';
                    hoursVal.textContent = '00';
                    minutesVal.textContent = '00';
                    secondsVal.textContent = '00';
                    @if($isLocked)
                        window.location.reload();
                    @endif
                    return;
                }

                const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((distance % (1000 * 60)) / 1000);

                daysVal.textContent = d < 10 ? '0' + d : d;
                hoursVal.textContent = h < 10 ? '0' + h : h;
                minutesVal.textContent = m < 10 ? '0' + m : m;
                secondsVal.textContent = s < 10 ? '0' + s : s;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        function selectEmoji(emoji, btn) {
            document.querySelectorAll('.emoji-btn').forEach(el => {
                el.classList.remove('ring-4', 'ring-rose-500/20', 'border-rose-500', 'bg-rose-50/30');
            });

            const hiddenInput = document.getElementById('selected_emoji');

            if (hiddenInput.value === emoji) {
                hiddenInput.value = '';
            } else {
                hiddenInput.value = emoji;
                btn.classList.add('ring-4', 'ring-rose-500/20', 'border-rose-500', 'bg-rose-50/30');
            }
        }
    </script>
</body>
</html>
