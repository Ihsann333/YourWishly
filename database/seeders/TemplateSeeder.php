<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
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
                'name' => 'Pernikahan',
                'emoji' => '💍',
                'theme_class' => 'bg-gradient-to-br from-rose-50 via-pink-50 to-amber-50 border border-pink-100',
                'text_color' => 'text-stone-900',
                'accent_color' => 'bg-pink-600/10 hover:bg-pink-600/20 text-pink-900 border-pink-500/30',
            ],
            [
                'name' => 'Hari Raya',
                'emoji' => '🌙',
                'theme_class' => 'bg-gradient-to-br from-emerald-800 via-green-800 to-emerald-950',
                'text_color' => 'text-white',
                'accent_color' => 'bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-200 border-emerald-400/40',
            ],
            [
                'name' => 'Anniversary',
                'emoji' => '❤️',
                'theme_class' => 'bg-gradient-to-br from-red-600 via-pink-600 to-rose-700',
                'text_color' => 'text-white',
                'accent_color' => 'bg-white/20 hover:bg-white/30 text-white border-white/40',
            ],
            [
                'name' => 'Perpisahan',
                'emoji' => '👋',
                'theme_class' => 'bg-gradient-to-br from-slate-800 via-slate-900 to-zinc-950',
                'text_color' => 'text-white',
                'accent_color' => 'bg-slate-700/50 hover:bg-slate-700/70 text-slate-200 border-slate-600/50',
            ],
        ];

        foreach ($templates as $template) {
            Template::firstOrCreate(['name' => $template['name']], $template);
        }
    }
}
