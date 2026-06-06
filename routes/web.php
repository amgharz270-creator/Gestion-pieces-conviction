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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RapportController;

// ========== PAGES PUBLIQUES ==========
Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

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
    
    // PROFILE (route simple)
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // ========== PROFIL UTILISATEUR (pour tous les utilisateurs connectés) ==========
    Route::get('/mon-profil', [UserController::class, 'profile'])->name('users.profile');
    Route::get('/mon-profil/modifier', [UserController::class, 'editProfile'])->name('users.editProfile');
    Route::put('/mon-profil', [UserController::class, 'updateProfile'])->name('users.updateProfile');
    Route::put('/mon-profil/password', [UserController::class, 'updateOwnPassword'])->name('users.updateOwnPassword');
    
    // ========== GESTION DES UTILISATEURS (seul l'admin peut accéder) ==========
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
    });
    
    // ========== PIECES (avec permission view_pieces) ==========
    //Route::middleware(['permission:view_pieces'])->group(function () {
        Route::resource('pieces', PieceConvictionController::class);
    //});
    
    // ========== DOSSIERS ==========
    Route::resource('dossiers', DossierController::class);
    
    // ========== EMPLACEMENTS ==========
    Route::resource('emplacements', EmplacementController::class);
    
    // ========== RESTITUTIONS ==========
    Route::resource('restitutions', RestitutionController::class);
    Route::patch('/restitutions/{restitution}/approuver', [RestitutionController::class, 'approuver'])
        ->name('restitutions.approuver');
    Route::post('/restitutions/{restitution}/effectuer', [RestitutionController::class, 'effectuer'])
        ->name('restitutions.effectuer');
    
    // ========== MOUVEMENTS ==========
    Route::resource('mouvements', MouvementController::class);
    Route::patch('/mouvements/{mouvement}/retour', [MouvementController::class, 'retour'])
        ->name('mouvements.retour');
    
    // ========== INVENTAIRES ==========
    Route::get('/inventaires-anomalies', [InventaireController::class, 'anomalies'])->name('inventaires.anomalies');
    Route::get('/inventaires-statistiques', [InventaireController::class, 'statistiques'])->name('inventaires.statistiques');
    Route::get('/inventaires/{inventaire}/export', [InventaireController::class, 'export'])->name('inventaires.export');
    Route::patch('/inventaires/{inventaire}/demarrer', [InventaireController::class, 'demarrer'])->name('inventaires.demarrer');
    Route::patch('/inventaires/{inventaire}/terminer', [InventaireController::class, 'terminer'])->name('inventaires.terminer');
    Route::patch('/inventaires-lignes/{ligne}', [InventaireController::class, 'updateLigne'])->name('inventaires.updateLigne');
    Route::resource('inventaires', InventaireController::class);

     // ========== ROLES & PERMISSIONS (admin only) ==========
    //Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
// ========== ROLES & PERMISSIONS ==========
Route::resource('roles', RoleController::class);
// ========== RAPPORTS & STATISTIQUES ==========
Route::middleware(['auth'])->prefix('rapports')->group(function () {
    Route::get('/', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/pieces', [RapportController::class, 'pieces'])->name('rapports.pieces');
    Route::get('/dossiers', [RapportController::class, 'dossiers'])->name('rapports.dossiers');
    Route::get('/restitutions', [RapportController::class, 'restitutions'])->name('rapports.restitutions');
    Route::get('/inventaires', [RapportController::class, 'inventaires'])->name('rapports.inventaires');
    Route::get('/mouvements', [RapportController::class, 'mouvements'])->name('rapports.mouvements');
    Route::get('/export-pdf/{type}', [RapportController::class, 'exportPDF'])->name('rapports.export-pdf');
    Route::get('/export-excel/{type}', [RapportController::class, 'exportExcel'])->name('rapports.export-excel');
});

}); 
//});
