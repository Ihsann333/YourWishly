<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CardController extends Controller
{
    public function create()
    {
        $templates = Template::all();
        return view('cards.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'sender_name' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:3072'],
            'template_id' => ['required', 'exists:templates,id'],
            'countdown_date' => ['nullable', 'date'],
        ]);

        // Generate a unique slug
        $baseSlug = Str::slug($request->event_type . '-' . $request->recipient_name);
        $slug = $baseSlug . '-' . rand(100, 999);
        while (Card::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . rand(100, 999);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('cards', 'public');
        }

        Card::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'recipient_name' => $request->recipient_name,
            'sender_name' => $request->sender_name,
            'event_type' => $request->event_type,
            'description' => $request->description,
            'body' => $request->body,
            'photo_path' => $photoPath,
            'template_id' => $request->template_id,
            'slug' => $slug,
            'countdown_date' => $request->countdown_date,
            'views_count' => 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kartu ucapan berhasil dibuat!');
    }

    public function edit(Card $card)
    {
        // Check authorization
        if ($card->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $templates = Template::all();
        return view('cards.edit', compact('card', 'templates'));
    }

    public function update(Request $request, Card $card)
    {
        // Check authorization
        if ($card->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'sender_name' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:3072'],
            'template_id' => ['required', 'exists:templates,id'],
            'countdown_date' => ['nullable', 'date'],
        ]);

        // If recipient name or event type changes, we could update the slug,
        // but it's usually better to keep the slug stable to avoid breaking shared links.
        // Let's only update the slug if the user explicitly wants to or keep it stable.
        // Let's keep it stable for simplicity and user convenience.

        $photoPath = $card->photo_path;
        if ($request->hasFile('photo')) {
            if ($card->photo_path) {
                Storage::disk('public')->delete($card->photo_path);
            }

            $photoPath = $request->file('photo')->store('cards', 'public');
        }

        $card->update([
            'title' => $request->title,
            'recipient_name' => $request->recipient_name,
            'sender_name' => $request->sender_name,
            'event_type' => $request->event_type,
            'description' => $request->description,
            'body' => $request->body,
            'photo_path' => $photoPath,
            'template_id' => $request->template_id,
            'countdown_date' => $request->countdown_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kartu ucapan berhasil diperbarui!');
    }

    public function destroy(Card $card)
    {
        // Check authorization
        if ($card->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($card->photo_path) {
            Storage::disk('public')->delete($card->photo_path);
        }

        $card->delete();

        return back()->with('success', 'Kartu ucapan berhasil dihapus.');
    }

    public function show($slug)
    {
        $card = Card::where('slug', $slug)->with(['template', 'greetings' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->firstOrFail();

        if (! $card->isLocked()) {
            $card->increment('views_count');
        }

        return view('cards.show', compact('card'));
    }
}
