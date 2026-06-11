<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Greeting;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    public function store(Request $request, Card $card)
    {
        if ($card->isLocked()) {
            return back()->with('error', 'Kartu ucapan masih terkunci sampai hitungan mundur selesai.');
        }

        $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'emoji_reaction' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('greetings', 'public');
        }

        Greeting::create([
            'card_id' => $card->id,
            'sender_name' => $request->sender_name,
            'message' => $request->message,
            'emoji_reaction' => $request->emoji_reaction,
            'photo_path' => $photoPath,
        ]);

        return back()->with('success', 'Ucapan Anda berhasil dikirim! Terima kasih.');
    }

    public function destroy(Greeting $greeting)
    {
        // Only card owner or admin can delete a greeting
        $card = $greeting->card;
        if ($card->user_id !== auth()->id() && (!auth()->check() || auth()->user()->role !== 'admin')) {
            abort(403, 'Unauthorized action.');
        }

        $greeting->delete();

        return back()->with('success', 'Ucapan berhasil dihapus.');
    }
}
