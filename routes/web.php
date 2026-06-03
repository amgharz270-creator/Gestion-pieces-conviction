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
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventaireController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    return redirect()->route('contact')->with('success', 'Message envoye avec succes !');
})->name('contact.send');

// ========== AUTH (GUEST ONLY) ==========

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ========== ROUTES PROTEGEES (AUTH) ==========

Route::middleware(['auth'])->group(function () {
    
    // DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // PROFILE
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // CRUD CONTROLLERS
    Route::resource('pieces', PieceConvictionController::class);
    Route::resource('dossiers', DossierController::class);
    Route::resource('emplacements', EmplacementController::class);
    Route::resource('restitutions', RestitutionController::class);
    Route::resource('mouvements', MouvementController::class);
    Route::resource('users', UserController::class);
    
    // ACTIONS CUSTOM RESTITUTIONS
    Route::patch('/restitutions/{restitution}/approuver', [RestitutionController::class, 'approuver'])
        ->name('restitutions.approuver');
    Route::post('/restitutions/{restitution}/effectuer', [RestitutionController::class, 'effectuer'])
        ->name('restitutions.effectuer');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
    // ACTIONS CUSTOM MOUVEMENTS
    Route::patch('/mouvements/{mouvement}/retour', [MouvementController::class, 'retour'])
        ->name('mouvements.retour');
    // Routes pour les inventaires
Route::resource('inventaires', InventaireController::class);
Route::patch('/inventaires/{inventaire}/demarrer', [InventaireController::class, 'demarrer'])->name('inventaires.demarrer');
Route::patch('/inventaires/{inventaire}/terminer', [InventaireController::class, 'terminer'])->name('inventaires.terminer');
Route::patch('/inventaires-lignes/{ligne}', [InventaireController::class, 'updateLigne'])->name('inventaires.updateLigne');
Route::get('/inventaires-anomalies', [InventaireController::class, 'anomalies'])->name('inventaires.anomalies');
Route::get('/inventaires/{inventaire}/export', [InventaireController::class, 'export'])->name('inventaires.export');
Route::get('/inventaires-statistiques', [InventaireController::class, 'statistiques'])->name('inventaires.statistiques');    
});