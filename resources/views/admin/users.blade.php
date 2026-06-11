@extends('layouts.app')

@section('title', 'Kelola Pengguna - Admin YourWishly')

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
        <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold bg-rose-50 text-rose-600 border border-rose-100">Kelola Pengguna</a>
        <a href="{{ route('admin.templates') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Kelola Template</a>
        <a href="{{ route('admin.cards') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Pantau Kartu</a>
    </div>

    <!-- Users Table Section -->
    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h2 class="font-extrabold text-slate-800 text-lg">Daftar Pengguna Terdaftar</h2>
            <span class="text-xs font-bold px-3 py-1 bg-slate-200/60 text-slate-600 rounded-full">{{ $users->count() }} Pengguna</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="px-8 py-5">Nama</th>
                        <th class="px-6 py-5">Email</th>
                        <th class="px-6 py-5">Peran</th>
                        <th class="px-6 py-5">Tanggal Registrasi</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <!-- User Name -->
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full bg-rose-50 text-rose-600 font-bold text-xs uppercase flex items-center justify-center border border-rose-100">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <span class="font-bold text-slate-800 text-sm">{{ $user->name }}</span>
                                </div>
                            </td>

                            <!-- User Email -->
                            <td class="px-6 py-5 text-sm font-medium text-slate-600">
                                {{ $user->email }}
                            </td>

                            <!-- User Role -->
                            <td class="px-6 py-5">
                                <span class="inline-block text-[10px] font-extrabold px-2.5 py-1 {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-100 text-slate-600 border border-slate-200' }} rounded-full uppercase tracking-wider">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <!-- Registered date -->
                            <td class="px-6 py-5 text-sm text-slate-500">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </td>

                            <!-- Action buttons -->
                            <td class="px-8 py-5 text-right space-x-1.5 whitespace-nowrap">
                                <!-- Change role button -->
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold bg-slate-100 hover:bg-indigo-50 hover:text-indigo-650 text-slate-600 px-3 py-2 rounded-xl border border-slate-200 hover:border-indigo-200 transition-all cursor-pointer">
                                            Ubah Peran
                                        </button>
                                    </form>

                                    <!-- Delete user button -->
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Semua kartu dan ucapannya juga akan dihapus secara permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold bg-white hover:bg-rose-50 hover:text-rose-600 text-slate-500 px-3 py-2 rounded-xl border border-slate-200 hover:border-rose-250 transition-all cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 font-semibold italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
