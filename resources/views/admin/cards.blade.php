@extends('layouts.app')

@section('title', 'Pantau Kartu - Admin YourWishly')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Admin Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Admin Panel</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola data pengguna, desain template, dan pantau kartu ucapan aktif di platform YourWishly.</p>
    </div>

    <!-- Admin Navigation Tabs -->
    <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-4 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Kelola Pengguna</a>
        <a href="{{ route('admin.templates') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Kelola Template</a>
        <a href="{{ route('admin.cards') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold bg-rose-50 text-rose-600 border border-rose-100">Pantau Kartu</a>
    </div>

    <!-- Cards List Section -->
    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="font-extrabold text-slate-800 text-lg">Daftar Semua Kartu Ucapan</h2>
            <span class="text-xs font-bold px-3 py-1 bg-slate-200/60 text-slate-600 rounded-full">{{ $cards->count() }} Kartu</span>
        </div>

        @if($cards->isEmpty())
            <div class="p-16 text-center text-slate-400">
                <span class="text-5xl block mb-4">✉️</span>
                <h3 class="font-bold text-lg text-slate-700">Belum ada kartu ucapan dibuat</h3>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-8 py-5">Pembuat</th>
                            <th class="px-6 py-5">Penerima & Acara</th>
                            <th class="px-6 py-5">Judul Kartu</th>
                            <th class="px-6 py-5 text-center">Ucapan</th>
                            <th class="px-6 py-5">Dibuat Pada</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($cards as $card)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <!-- Card Owner -->
                                <td class="px-8 py-5">
                                    <div>
                                        <span class="block font-bold text-slate-800 text-sm">{{ $card->user->name ?? 'Dihapus' }}</span>
                                        <span class="block text-slate-450 text-[10px]">{{ $card->user->email ?? '-' }}</span>
                                    </div>
                                </td>

                                <!-- Recipient & Event -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xl">{{ $card->template->emoji ?? '✉️' }}</span>
                                        <div>
                                            <span class="block font-bold text-slate-700 text-sm">{{ $card->recipient_name }}</span>
                                            <span class="inline-block text-[9px] font-extrabold px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded uppercase tracking-wider mt-0.5">{{ $card->event_type }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Title -->
                                <td class="px-6 py-5 text-sm text-slate-600 font-medium max-w-xs truncate">
                                    {{ $card->title }}
                                </td>

                                <!-- Greetings count -->
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 text-xs font-bold bg-amber-50 text-amber-600 rounded-full border border-amber-100">
                                        {{ $card->greetings->count() }} ucapan
                                    </span>
                                </td>

                                <!-- Created at date -->
                                <td class="px-6 py-5 text-sm text-slate-500">
                                    {{ $card->created_at->format('d M Y, H:i') }}
                                </td>

                                <!-- Action buttons -->
                                <td class="px-8 py-5 text-right space-x-1.5 whitespace-nowrap">
                                    <!-- Open Card -->
                                    <a href="{{ route('card.show', $card->slug) }}" target="_blank" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-450 hover:text-emerald-500 hover:bg-emerald-50/50 border border-slate-200/60 hover:border-emerald-200/50 transition-all" title="Buka Halaman Kartu">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Card -->
                                    <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu ucapan ini? Seluruh ucapan didalamnya juga akan dihapus secara permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-455 hover:text-rose-600 hover:bg-rose-50/60 border border-slate-200/60 hover:border-rose-300/60 transition-all cursor-pointer" title="Hapus Kartu">
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
@endsection
