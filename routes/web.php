<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ========== PAGES PUBLIQUES (avec navbar + footer) ==========

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    // Traitement du formulaire de contact
    return redirect()->route('contact')->with('success', 'Message envoyé avec succès !');
})->name('contact.send');

// ========== AUTH (sans navbar + footer) ==========

// Afficher les formulaires
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Traiter les formulaires
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== DASHBOARD (protégé par auth) ==========

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::resource('pieces', PieceConvictionController::class);
Route::resource('dossiers', DossierController::class);
// ========== ROUTES LARAVEL BREEZE/JETSTREAM ==========
// require __DIR__.'/auth.php';