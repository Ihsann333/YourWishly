<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Card;
use App\Models\Greeting;
use App\Models\Template;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'cards' => Card::count(),
            'greetings' => Greeting::count(),
            'templates' => Template::count(),
        ];

        // Recent users and cards
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentCards = Card::with(['user', 'template'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentCards'));
    }

    // --- USER MANAGEMENT ---
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function toggleUserRole(User $user)
    {
        // Don't let admin demote themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah peran Anda sendiri.');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', 'Peran pengguna berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    // --- TEMPLATE MANAGEMENT ---
    public function templates()
    {
        $templates = Template::all();
        return view('admin.templates', compact('templates'));
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'emoji' => ['required', 'string', 'max:10'],
            'theme_class' => ['required', 'string', 'max:255'],
            'text_color' => ['required', 'string', 'max:255'],
            'accent_color' => ['required', 'string', 'max:255'],
        ]);

        Template::create([
            'name' => $request->name,
            'emoji' => $request->emoji,
            'theme_class' => $request->theme_class,
            'text_color' => $request->text_color,
            'accent_color' => $request->accent_color,
        ]);

        return back()->with('success', 'Template desain baru berhasil ditambahkan!');
    }

    public function updateTemplate(Request $request, Template $template)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'emoji' => ['required', 'string', 'max:10'],
            'theme_class' => ['required', 'string', 'max:255'],
            'text_color' => ['required', 'string', 'max:255'],
            'accent_color' => ['required', 'string', 'max:255'],
        ]);

        $template->update([
            'name' => $request->name,
            'emoji' => $request->emoji,
            'theme_class' => $request->theme_class,
            'text_color' => $request->text_color,
            'accent_color' => $request->accent_color,
        ]);

        return back()->with('success', 'Template desain berhasil diperbarui!');
    }

    public function deleteTemplate(Template $template)
    {
        // Check if there are cards using this template. If so, they'll have template_id set to null.
        $template->delete();
        return back()->with('success', 'Template desain berhasil dihapus.');
    }

    // --- CARD MANAGEMENT (MODERATION) ---
    public function cards()
    {
        $cards = Card::with(['user', 'template', 'greetings'])->orderBy('created_at', 'desc')->get();
        return view('admin.cards', compact('cards'));
    }
}
