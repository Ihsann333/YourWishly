@extends('layouts.app')

@section('title', 'Kelola Template - Admin YourWishly')

@section('content')
@php
    $templatePresets = [
        [
            'name' => 'Ulang Tahun',
            'emoji' => '🎂',
            'theme_class' => 'bg-gradient-to-br from-pink-500 via-rose-500 to-amber-400',
            'text_color' => 'text-white',
            'accent_color' => 'bg-white/20 hover:bg-white/30 text-white border-white/40',
        ],
        [
            'name' => 'Wisuda',
            'emoji' => '🎓',
            'theme_class' => 'bg-gradient-to-br from-blue-900 via-indigo-900 to-cyan-900',
            'text_color' => 'text-white',
            'accent_color' => 'bg-cyan-500/20 hover:bg-cyan-500/30 text-cyan-200 border-cyan-400/40',
        ],
        [
            'name' => 'Hari Raya',
            'emoji' => '🌙',
            'theme_class' => 'bg-gradient-to-br from-emerald-800 via-green-800 to-emerald-950',
            'text_color' => 'text-white',
            'accent_color' => 'bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-200 border-emerald-400/40',
        ],
    ];
@endphp

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
        <a href="{{ route('admin.templates') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold bg-rose-50 text-rose-600 border border-rose-100">Kelola Template</a>
        <a href="{{ route('admin.cards') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">Pantau Kartu</a>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: List templates -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white px-8 py-6 rounded-[32px] border border-slate-100 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 border-b border-slate-100 pb-4">
                    <h2 class="font-extrabold text-slate-800 text-lg">Daftar Template Desain</h2>
                    <span class="text-xs font-bold px-3 py-1 bg-slate-200/60 text-slate-600 rounded-full">{{ $templates->count() }} Template</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($templates as $template)
                        <div class="rounded-2xl p-5 flex flex-col justify-between shadow-sm relative overflow-hidden group {{ $template->theme_class }} {{ $template->text_color }}">
                            <div class="flex justify-between items-start gap-3">
                                <span class="text-4xl">{{ $template->emoji }}</span>
                                
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        data-template-id="{{ $template->id }}"
                                        data-template-name="{{ $template->name }}"
                                        data-template-emoji="{{ $template->emoji }}"
                                        data-template-theme-class="{{ $template->theme_class }}"
                                        data-template-text-color="{{ $template->text_color }}"
                                        data-template-accent-color="{{ $template->accent_color }}"
                                        onclick="editTemplate(this)"
                                        class="bg-white/20 hover:bg-white/30 backdrop-blur-md p-2 rounded-lg border border-white/20 text-white cursor-pointer transition-colors"
                                        title="Edit Template"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-5-5l5-5m0 0l3 3m-3-3l-3 3" />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openDeleteTemplateModal({{ $template->id }}, @js($template->name))"
                                        class="bg-white/20 hover:bg-white/30 backdrop-blur-md p-2 rounded-lg border border-white/20 text-white cursor-pointer transition-colors"
                                        title="Hapus Template"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <span class="block font-black text-xl tracking-tight leading-tight">{{ $template->name }}</span>
                                <span class="block text-[10px] opacity-75 mt-1 uppercase tracking-wider font-bold">Accent: {{ $template->accent_color }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-sm text-center col-span-2 py-8">Belum ada template desain.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Create/Edit template form -->
        <div class="space-y-6">
            <div class="bg-white p-6 sm:p-8 rounded-[32px] border border-slate-100 shadow-sm">
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-4 mb-6">
                    <div>
                        <h2 id="templateFormTitle" class="font-extrabold text-slate-800 text-lg">Tambah Template Baru</h2>
                        <p id="templateFormSubtitle" class="text-slate-500 text-sm mt-1">Pilih preset cepat atau isi manual untuk membuat template baru.</p>
                    </div>
                    <button type="button" onclick="resetTemplateForm()" class="text-xs font-bold text-rose-600 hover:text-rose-700 transition-colors">
                        Reset
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-6">
                    @foreach($templatePresets as $preset)
                        <button
                            type="button"
                            onclick='applyPreset(@js($preset))'
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-3 text-left hover:bg-slate-100 transition-colors"
                        >
                            <span class="block text-lg">{{ $preset['emoji'] }}</span>
                            <span class="block text-xs font-bold text-slate-700 mt-1">{{ $preset['name'] }}</span>
                        </button>
                    @endforeach
                </div>

                <form id="templateForm" action="{{ route('admin.templates.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" id="templateMethod" name="_method" value="POST">

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Contoh: Graduation Gold">
                    </div>

                    <div>
                        <label for="emoji" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Emoji Icon</label>
                        <input type="text" id="emoji" name="emoji" required value="{{ old('emoji') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Contoh: 🎓">
                    </div>

                    <div>
                        <label for="theme_class" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">CSS Background Class</label>
                        <input type="text" id="theme_class" name="theme_class" required value="{{ old('theme_class') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Contoh: bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900">
                    </div>

                    <div>
                        <label for="text_color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">CSS Text Class</label>
                        <input type="text" id="text_color" name="text_color" required value="{{ old('text_color', 'text-white') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Contoh: text-white atau text-slate-800">
                    </div>

                    <div>
                        <label for="accent_color" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">CSS Accent Badge Class</label>
                        <input type="text" id="accent_color" name="accent_color" required value="{{ old('accent_color') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm transition-all"
                            placeholder="Contoh: bg-indigo-500/20 text-indigo-200 border-indigo-400/40">
                    </div>

                    <div class="pt-2 flex gap-3">
                        <button id="templateSubmitButton" type="submit" class="w-full bg-gradient-to-r from-rose-500 to-amber-500 hover:from-rose-600 hover:to-amber-600 text-white font-bold py-3 px-4 rounded-xl text-sm shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                            Simpan Template
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- Delete Template Modal -->
<div id="deleteTemplateModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-950/45" onclick="closeDeleteTemplateModal()"></div>

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
                        <h3 class="text-lg font-bold text-slate-800">Hapus template ini?</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Template <span id="deleteTemplateName" class="font-semibold text-slate-700"></span> akan dihapus dari daftar template.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row gap-3 sm:justify-end">
                <button type="button" onclick="closeDeleteTemplateModal()" class="w-full sm:w-auto rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="button" onclick="confirmDeleteTemplate()" class="w-full sm:w-auto rounded-xl px-4 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 transition-colors cursor-pointer">
                    Ya, hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteTemplateFormId = null;

    function setTemplateFormMode(mode, templateId = null) {
        const title = document.getElementById('templateFormTitle');
        const subtitle = document.getElementById('templateFormSubtitle');
        const submitButton = document.getElementById('templateSubmitButton');
        const method = document.getElementById('templateMethod');
        const form = document.getElementById('templateForm');

        if (mode === 'edit') {
            title.textContent = 'Edit Template';
            subtitle.textContent = 'Ubah template yang sudah ada tanpa perlu pindah halaman.';
            submitButton.textContent = 'Update Template';
            method.value = 'PUT';
            form.action = `{{ url('/admin/templates') }}/${templateId}`;
            return;
        }

        title.textContent = 'Tambah Template Baru';
        subtitle.textContent = 'Pilih preset cepat atau isi manual untuk membuat template baru.';
        submitButton.textContent = 'Simpan Template';
        method.value = 'POST';
        form.action = @json(route('admin.templates.store'));
    }

    function applyPreset(preset) {
        document.getElementById('name').value = preset.name || '';
        document.getElementById('emoji').value = preset.emoji || '';
        document.getElementById('theme_class').value = preset.theme_class || '';
        document.getElementById('text_color').value = preset.text_color || '';
        document.getElementById('accent_color').value = preset.accent_color || '';
        setTemplateFormMode('create');
    }

    function editTemplate(button) {
        document.getElementById('name').value = button.dataset.templateName || '';
        document.getElementById('emoji').value = button.dataset.templateEmoji || '';
        document.getElementById('theme_class').value = button.dataset.templateThemeClass || '';
        document.getElementById('text_color').value = button.dataset.templateTextColor || '';
        document.getElementById('accent_color').value = button.dataset.templateAccentColor || '';
        setTemplateFormMode('edit', button.dataset.templateId);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetTemplateForm() {
        document.getElementById('templateForm').reset();
        setTemplateFormMode('create');
        document.getElementById('text_color').value = 'text-white';
    }

    function openDeleteTemplateModal(templateId, templateName) {
        deleteTemplateFormId = templateId;
        document.getElementById('deleteTemplateName').textContent = templateName;
        document.getElementById('deleteTemplateModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteTemplateModal() {
        deleteTemplateFormId = null;
        document.getElementById('deleteTemplateModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function confirmDeleteTemplate() {
        if (!deleteTemplateFormId) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/admin/templates') }}/${deleteTemplateFormId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDeleteTemplateModal();
        }
    });
</script>
@endsection
