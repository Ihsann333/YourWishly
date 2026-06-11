@extends('layouts.app')

@section('title', 'Admin Dashboard - YourWishly')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Admin Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Admin Panel</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola data pengguna, desain template, dan pantau kartu ucapan aktif di platform YourWishly.</p>
    </div>

    <!-- Admin Navigation Tabs -->
    <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-4 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold bg-rose-50 text-rose-600 border border-rose-100">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Kelola Pengguna</a>
        <a href="{{ route('admin.templates') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Kelola Template</a>
        <a href="{{ route('admin.cards') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Pantau Kartu</a>
    </div>

    <!-- Overall Statistics Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Users count -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-500/10 rounded-2xl text-blue-500 flex items-center justify-center text-xl font-bold">👥</div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Pengguna</span>
                <span class="text-2xl font-black text-slate-800">{{ $stats['users'] }}</span>
            </div>
        </div>

        <!-- Cards count -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-rose-500/10 rounded-2xl text-rose-500 flex items-center justify-center text-xl font-bold">✉️</div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Kartu</span>
                <span class="text-2xl font-black text-slate-800">{{ $stats['cards'] }}</span>
            </div>
        </div>

        <!-- Greetings count -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl text-amber-550 flex items-center justify-center text-xl font-bold">💬</div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Ucapan</span>
                <span class="text-2xl font-black text-slate-800">{{ $stats['greetings'] }}</span>
            </div>
        </div>

        <!-- Templates count -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl text-indigo-500 flex items-center justify-center text-xl font-bold">🎨</div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase tracking-wider">Template</span>
                <span class="text-2xl font-black text-slate-800">{{ $stats['templates'] }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Tables Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Users -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-850 text-base">Registrasi Pengguna Terbaru</h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-bold text-rose-500 hover:text-rose-600 transition-colors">Lihat Semua</a>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($recentUsers as $usr)
                    <div class="px-6 py-4 flex justify-between items-center hover:bg-slate-50/20 transition-colors">
                        <div>
                            <span class="block font-bold text-slate-800 text-sm">{{ $usr->name }}</span>
                            <span class="block text-slate-400 text-xs mt-0.5">{{ $usr->email }}</span>
                        </div>
                        <span class="text-xs font-semibold px-2 py-1 {{ $usr->role === 'admin' ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-100 text-slate-600' }} rounded-lg uppercase tracking-wider">
                            {{ $usr->role }}
                        </span>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">Belum ada pengguna terdaftar</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Cards -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-850 text-base">Kartu Ucapan Terbaru</h3>
                <a href="{{ route('admin.cards') }}" class="text-xs font-bold text-rose-500 hover:text-rose-600 transition-colors">Lihat Semua</a>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($recentCards as $crd)
                    <div class="px-6 py-4 flex justify-between items-center hover:bg-slate-50/20 transition-colors">
                        <div>
                            <span class="block font-bold text-slate-850 text-sm">{{ $crd->recipient_name }}</span>
                            <span class="block text-slate-400 text-xs mt-0.5">Dibuat oleh: {{ $crd->user->name ?? 'Dihapus' }} &bull; {{ $crd->event_type }}</span>
                        </div>
                        <a href="{{ route('card.show', $crd->slug) }}" target="_blank" class="text-xs bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-rose-200 transition-all font-semibold">
                            Buka
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">Belum ada kartu ucapan dibuat</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
