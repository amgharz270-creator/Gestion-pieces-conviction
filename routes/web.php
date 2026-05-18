<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PieceConvictionController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\EmplacementController;
use App\Http\Controllers\RestitutionController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\UserController;

// ========== PAGES PUBLIQUES ==========

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
    return redirect()->route('contact')->with('success', 'Message envoyé avec succès !');
})->name('contact.send');

// ========== AUTH ==========

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== ROUTES PROTÉGÉES (auth) ==========

Route::middleware(['auth'])->group(function () {
    
    // ⭐ DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // ⭐ PROFILE
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // ⭐ CRUD CONTROLLERS (CHAQUE ROUTE UNE SEULE FOIS!)
    Route::resource('pieces', PieceConvictionController::class);
    Route::resource('dossiers', DossierController::class);
    Route::resource('emplacements', EmplacementController::class);
    Route::resource('restitutions', RestitutionController::class);
    Route::resource('mouvements', MouvementController::class);
    Route::resource('users', UserController::class);
    
});