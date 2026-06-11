<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all cards for this user
        $cards = $user->cards()->with(['template', 'greetings'])->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalCards = $cards->count();
        
        $totalGreetings = 0;
        foreach ($cards as $card) {
            $totalGreetings += $card->greetings->count();
        }

        // Get popular card by views_count
        $popularCard = $user->cards()->orderBy('views_count', 'desc')->first();

        return view('dashboard', compact('cards', 'totalCards', 'totalGreetings', 'popularCard'));
    }
}
