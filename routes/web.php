<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GreetingController;
use App\Models\Card;
use App\Models\Greeting;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', function () {
    $totalCards = Card::count();
    $totalGreetings = Greeting::count();
    return view('home', compact('totalCards', 'totalGreetings'));
})->name('home');

// Public Card Page
Route::get('/card/{slug}', [CardController::class, 'show'])->name('card.show');
Route::post('/card/{card}/greeting', [GreetingController::class, 'store'])->name('greeting.store');

// Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cards CRUD
    Route::get('/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');
    Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');

    // Greeting Deletion
    Route::delete('/greeting/{greeting}', [GreetingController::class, 'destroy'])->name('greeting.destroy');
});

// Admin Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleUserRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Template management
    Route::get('/templates', [AdminController::class, 'templates'])->name('templates');
    Route::post('/templates', [AdminController::class, 'storeTemplate'])->name('templates.store');
    Route::put('/templates/{template}', [AdminController::class, 'updateTemplate'])->name('templates.update');
    Route::delete('/templates/{template}', [AdminController::class, 'deleteTemplate'])->name('templates.delete');

    // Card moderation
    Route::get('/cards', [AdminController::class, 'cards'])->name('cards');
});
