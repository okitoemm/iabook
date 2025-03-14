<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectFeedController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes pour les artisans
Route::prefix('artisans')->name('artisans.')->group(function () {
    Route::get('/', [App\Http\Controllers\ArtisanController::class, 'index'])->name('index');
    Route::get('/{id}', [App\Http\Controllers\ArtisanController::class, 'show'])->name('show');
    Route::get('/{id}/contact', [App\Http\Controllers\ArtisanController::class, 'contact'])->name('contact');
});

Route::get('/register', [AuthController::class, 'register'])->name('register');

// Routes d'inscription
Route::get('register/client', [RegisterController::class, 'showClientRegistrationForm'])->name('register.client');
Route::post('register/client', [RegisterController::class, 'registerClient'])->name('register.client.post');

Route::get('register/artisan', [RegisterController::class, 'showArtisanRegistrationForm'])->name('register.artisan');
Route::post('register/artisan', [RegisterController::class, 'registerArtisan'])->name('register.artisan.post');

// Routes des projets accessibles une fois connecté
Route::middleware(['auth'])->group(function () {
    // Liste des projets disponibles
    Route::get('/projects/available', [ProjectController::class, 'available'])
        ->name('projects.available');
        
    // Autres routes de projets
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/preview', [ProjectController::class, 'preview'])->name('projects.preview');
    
    Route::post('/projects/{project}/messages', [MessageController::class, 'store'])
        ->name('messages.store');
    
    // Change the messages route to include project_id
    Route::post('/projects/{project}/contact', [MessageController::class, 'store'])
        ->name('messages.store');
    
    // Messages et contacts
    Route::post('/projects/{project}/contact', [MessageController::class, 'store'])
        ->name('projects.contact');
    Route::get('/messages', [MessageController::class, 'index'])
        ->name('messages.index');
});

// Route temporaire pour vérifier la structure de la table
Route::get('/check-projects-table', function() {
    $columns = Schema::getColumnListing('projects');
    dd([
        'all_columns' => $columns,
        'has_photos' => Schema::hasColumn('projects', 'photos'),
        'has_video' => Schema::hasColumn('projects', 'video_path'),
        'has_verification' => Schema::hasColumn('projects', 'verification_method'),
        'has_availability' => Schema::hasColumn('projects', 'availability_hours'),
        'has_urgent' => Schema::hasColumn('projects', 'urgent'),
    ]);
});

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// Pages légales
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
});

// Routes du tableau de bord
Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
});

// Routes de messagerie
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
});

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes des paramètres
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings.show');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.account.delete');
});

// Routes d'authentification
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routes pour l'authentification Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('google.callback');

// Routes pour les artisans - Utilisation d'un seul groupe de routes
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsArtisan::class])->group(function () {
    Route::prefix('artisan')->name('artisan.')->group(function () {
        Route::get('dashboard', [ArtisanController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [ArtisanController::class, 'profile'])->name('profile');
        Route::patch('profile/update', [ArtisanController::class, 'updateProfile'])->name('profile.update'); // Correction ici
        Route::get('projects/feed', [ProjectFeedController::class, 'index'])->name('projects.feed');
        Route::get('projects/{project}', [ProjectFeedController::class, 'show'])->name('projects.show');
        Route::post('projects/{project}/contact', [ProjectFeedController::class, 'contact'])->name('projects.contact');
    });
});

// Routes pour compléter le profil
Route::middleware(['auth'])->group(function () {
    Route::get('/artisan/complete-profile', [ArtisanController::class, 'showCompleteProfile'])
        ->name('artisan.complete-profile');
    Route::post('/artisan/complete-profile', [ArtisanController::class, 'completeProfile']);
    
    Route::get('/client/complete-profile', [ClientController::class, 'showCompleteProfile'])
        ->name('client.complete-profile');
    Route::post('/client/complete-profile', [ClientController::class, 'completeProfile']);
});

// Routes de sélection de rôle
Route::middleware(['web'])->group(function () {
    Route::get('/select-role', [App\Http\Controllers\Auth\RoleSelectionController::class, 'show'])->name('role.select');
    Route::post('/select-role', [App\Http\Controllers\Auth\RoleSelectionController::class, 'store'])->name('role.store');
});

// Redirection de /dashboard vers la bonne route selon le rôle
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return auth()->user()->isArtisan() 
            ? redirect()->route('artisan.dashboard')
            : redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');