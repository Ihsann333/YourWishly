@extends('layouts.app')

@section('title', 'Dashboard - YourWishly')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Top Greeting and CTA -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard Anda</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola kartu ucapan digital Anda dan lihat statistik ucapan yang masuk.</p>
        </div>
        <div>
            <a href="{{ route('cards.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-bold px-6 py-3 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Buat Kartu Baru</span>
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <!-- Total Cards -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-5">
            <div class="w-14 h-14 bg-rose-500/10 rounded-2xl text-rose-500 flex items-center justify-center text-2xl font-bold">
                ✉️
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Total Kartu</span>
                <span class="text-3xl font-black text-slate-800">{{ $totalCards }}</span>
            </div>
        </div>

        <!-- Total Greetings -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-5">
            <div class="w-14 h-14 bg-amber-500/10 rounded-2xl text-amber-500 flex items-center justify-center text-2xl font-bold">
                💬
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Ucapan Masuk</span>
                <span class="text-3xl font-black text-slate-800">{{ $totalGreetings }}</span>
            </div>
        </div>

        <!-- Most Popular Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl text-indigo-500 flex items-center justify-center text-2xl font-bold">
                🔥
            </div>
            <div class="flex-1 min-w-0">
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Kartu Terpopuler</span>
                @if($popularCard)
                    <span class="block text-sm font-bold text-slate-700 truncate mt-0.5">{{ $popularCard->recipient_name }}</span>
                    <span class="block text-xs text-slate-500">{{ $popularCard->views_count }} Kunjungan</span>
                @else
                    <span class="text-sm text-slate-500 font-bold block mt-0.5">Belum ada data</span>
                @endif
            </div>
        </div>

    </div>

    <!-- Cards List Section -->
    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="font-extrabold text-slate-800 text-lg">Daftar Kartu Ucapan Anda</h2>
            <span class="text-xs font-bold px-3 py-1 bg-slate-200/60 text-slate-600 rounded-full">{{ $cards->count() }} Kartu</span>
        </div>

        @if($cards->isEmpty())
            <div class="p-16 text-center">
                <span class="text-5xl block mb-4">📭</span>
                <h3 class="font-extrabold text-slate-700 text-lg mb-1">Belum ada kartu ucapan</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">
                    Buat kartu ucapan pertamamu untuk dibagikan ke teman dan keluarga sekarang juga.
                </p>
                <a href="{{ route('cards.create') }}" class="inline-flex items-center space-x-2 bg-rose-50 hover:bg-rose-100 text-rose-600 px-5 py-3 rounded-2xl font-bold text-sm transition-colors border border-rose-200/50 cursor-pointer">
                    <span>Mulai Sekarang</span>
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-8 py-5">Penerima & Acara</th>
                            <th class="px-6 py-5">Judul Kartu</th>
                            <th class="px-6 py-5">Template</th>
                            <th class="px-6 py-5 text-center">Kunjungan</th>
                            <th class="px-6 py-5 text-center">Ucapan</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($cards as $card)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <!-- Recipient & Event Type -->
                                <td class="px-8 py-5">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">{{ $card->template->emoji ?? '✉️' }}</span>
                                        <div>
                                            <span class="block font-bold text-slate-800 text-sm sm:text-base">{{ $card->recipient_name }}</span>
                                            <span class="inline-block text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md uppercase tracking-wider mt-0.5">{{ $card->event_type }}</span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Card Title -->
                                <td class="px-6 py-5 text-sm font-medium text-slate-700 max-w-xs truncate">
                                    {{ $card->title }}
                                </td>

                                <!-- Template styling -->
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $card->template->theme_class ?? 'bg-slate-100' }} {{ $card->template->text_color ?? 'text-slate-800' }} border border-black/5">
                                        <span>{{ $card->template->name ?? 'Default' }}</span>
                                    </span>
                                </td>

                                <!-- Views count -->
                                <td class="px-6 py-5 text-center text-sm font-semibold text-slate-600">
                                    {{ $card->views_count }}
                                </td>

                                <!-- Greetings count -->
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-extrabold bg-amber-50 text-amber-600 rounded-full border border-amber-100">
                                        {{ $card->greetings->count() }} ucapan
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-8 py-5 text-right space-x-1.5 whitespace-nowrap">
                                    <!-- Copy Link Button -->
                                    <button onclick="copyLink('{{ route('card.show', $card->slug) }}', this)" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-rose-500 hover:bg-rose-50/50 border border-slate-200/60 hover:border-rose-200/50 transition-all cursor-pointer" title="Salin Link">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>

                                    <!-- QR Code Modal Link -->
                                    <button type="button" onclick="openQRModal(@js(route('card.show', $card->slug)), @js($card->recipient_name))" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-indigo-500 hover:bg-indigo-50/50 border border-slate-200/60 hover:border-indigo-200/50 transition-all cursor-pointer" title="Lihat QR Code">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </button>

                                    <!-- View Card -->
                                    <a href="{{ route('card.show', $card->slug) }}" target="_blank" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-emerald-500 hover:bg-emerald-50/50 border border-slate-200/60 hover:border-emerald-200/50 transition-all" title="Buka Halaman Kartu">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Edit Card -->
                                    <a href="{{ route('cards.edit', $card->id) }}" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-blue-500 hover:bg-blue-50/50 border border-slate-200/60 hover:border-blue-200/50 transition-all" title="Edit Kartu">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-5-5l5-5m0 0l3 3m-3-3l-3 3" />
                                        </svg>
                                    </a>

                                    <!-- Delete Card -->
                                    <form id="delete-form-{{ $card->id }}" action="{{ route('cards.destroy', $card->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openDeleteModal({{ $card->id }}, @js($card->recipient_name))" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50/60 border border-slate-200/60 hover:border-rose-300/60 transition-all cursor-pointer" title="Hapus Kartu">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<!-- QR Code Modal -->
<div id="qrModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/45" onclick="closeQRModal()"></div>

    <div class="relative flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.25)]">
            <div class="px-6 pt-6 pb-5">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-slate-800 mb-1" id="qrModalTitle">QR Code Kartu</h3>
                    <p class="text-slate-400 text-xs mb-6">Scan QR Code ini untuk membuka atau membagikan kartu ucapan.</p>

                    <div class="mx-auto flex h-[280px] w-[280px] items-center justify-center rounded-3xl border border-slate-100 bg-slate-50 p-5">
                        <img id="qrCodeImg" src="" alt="QR Code" class="h-56 w-56 object-contain">
                        <p id="qrFallback" class="hidden h-56 w-56 items-center justify-center text-center text-sm font-semibold text-slate-400">
                            QR code sedang diproses.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4">
                <button onclick="closeQRModal()" class="w-full rounded-xl bg-white px-4 py-2.5 text-center text-sm font-bold text-slate-700 transition-colors hover:bg-slate-100 cursor-pointer border border-slate-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[60] hidden" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-950/45" onclick="closeDeleteModal()"></div>

    <div class="relative flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.25)]">
            <div class="px-6 pt-6 pb-5">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-rose-100 bg-rose-50 text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3l-8.47-14.14a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-800">Hapus kartu ini?</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kartu <span id="deleteCardName" class="font-semibold text-slate-700"></span> akan dihapus permanen beserta semua ucapannya.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4 flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition-colors hover:bg-slate-100 cursor-pointer">
                    Batal
                </button>
                <button type="button" onclick="confirmDelete()" class="w-full sm:w-auto rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white transition-colors hover:bg-rose-700 cursor-pointer">
                    Ya, hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Copy Link functionality
    function copyLink(link, button) {
        navigator.clipboard.writeText(link).then(() => {
            const originalIcon = button.innerHTML;
            button.innerHTML = `
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            `;
            button.classList.add('bg-emerald-50/50', 'border-emerald-200');
            
            setTimeout(() => {
                button.innerHTML = originalIcon;
                button.classList.remove('bg-emerald-50/50', 'border-emerald-200');
            }, 2000);
        }).catch(err => {
            alert('Gagal menyalin link: ' + err);
        });
    }

    // QR Code Modal functionality
    function setModalState(isOpen) {
        document.body.classList.toggle('overflow-hidden', isOpen);
    }

    async function openQRModal(url, recipient) {
        const modal = document.getElementById('qrModal');
        const qrImg = document.getElementById('qrCodeImg');
        const qrFallback = document.getElementById('qrFallback');

        closeDeleteModal(false);
        document.getElementById('qrModalTitle').textContent = `QR Code - ${recipient}`;
        qrImg.alt = `QR Code untuk ${recipient}`;
        qrImg.src = '';
        qrImg.classList.add('hidden');
        qrFallback.textContent = 'QR code sedang diproses.';
        qrFallback.classList.remove('hidden');
        qrFallback.classList.add('flex');
        modal.classList.remove('hidden');
        setModalState(true);

        try {
            qrImg.src = await window.generateYourWishlyQr(url);
            qrImg.classList.remove('hidden');
            qrFallback.classList.add('hidden');
            qrFallback.classList.remove('flex');
        } catch (error) {
            console.error('Gagal generate QR code:', error);
            qrFallback.textContent = 'QR code gagal dibuat. Silakan salin link kartu dari tombol di samping.';
        }
    }

    function closeQRModal() {
        document.getElementById('qrModal').classList.add('hidden');
        document.getElementById('qrCodeImg').classList.remove('hidden');
        document.getElementById('qrCodeImg').src = '';
        document.getElementById('qrFallback').classList.add('hidden');
        document.getElementById('qrFallback').classList.remove('flex');
        document.getElementById('qrFallback').textContent = 'QR code sedang diproses.';
        setModalState(false);
    }

    let deleteFormId = null;

    function openDeleteModal(cardId, cardName) {
        closeQRModal();
        deleteFormId = `delete-form-${cardId}`;
        document.getElementById('deleteCardName').textContent = cardName;
        document.getElementById('deleteModal').classList.remove('hidden');
        setModalState(true);
    }

    function closeDeleteModal(restoreBody = true) {
        deleteFormId = null;
        document.getElementById('deleteModal').classList.add('hidden');
        if (restoreBody) {
            setModalState(false);
        }
    }

    function confirmDelete() {
        if (!deleteFormId) {
            return;
        }

        document.getElementById(deleteFormId).submit();
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeQRModal();
            closeDeleteModal();
        }
    });
</script>
@endsection
