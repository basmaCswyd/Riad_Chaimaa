<?php

use Illuminate\Support\Facades\Route;

// Importation de tous les contrôleurs pour garder le fichier propre
use App\Http\Controllers\ProfileController;
// Contrôleurs Client
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ReservationController as ClientReservationController;
use App\Http\Controllers\Client\FeedbackController as ClientFeedbackController;
use App\Http\Controllers\Client\NotificationController as ClientNotificationController;
// Contrôleurs Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// CORRECTION : Le nom du contrôleur de menu est MenuItemController
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;

/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES (ACCESSIBLES À TOUS)
|--------------------------------------------------------------------------
*/

// Page d'accueil (menu des plats)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page de détails d'un plat
Route::get('/menu/{menuItem}', [HomeController::class, 'showMenuItem'])->name('menu.show');

// Page "À propos de nous"
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Les routes d'authentification (login, register, etc.)
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| 2. ROUTES CLIENT (NÉCESSITENT D'ÊTRE CONNECTÉ)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Profil de l'utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Réservations du client
    Route::prefix('reservations')->name('client.reservations.')->group(function() {
        Route::get('/', [ClientReservationController::class, 'index'])->name('index');
        Route::get('/create', [ClientReservationController::class, 'create'])->name('create');
        Route::post('/', [ClientReservationController::class, 'store'])->name('store');
        Route::get('/download/{reservation}', [ClientReservationController::class, 'downloadPdf'])->name('downloadPdf');
    });
    
    // Route spéciale pour l'appel AJAX de vérification de disponibilité
    Route::get('/check-availability', [ClientReservationController::class, 'checkAvailability'])->name('client.availability.check');

    // Feedback du client
    Route::prefix('feedback')->name('client.feedback.')->group(function() {
        Route::get('/', [ClientFeedbackController::class, 'create'])->name('create');
        Route::post('/', [ClientFeedbackController::class, 'store'])->name('store');
    });

    // Boîte de messagerie / notifications du client
    Route::prefix('notifications')->name('client.notifications.')->group(function() {
        Route::get('/', [ClientNotificationController::class, 'index'])->name('index');
        Route::get('/{message}', [ClientNotificationController::class, 'show'])->name('show');
        Route::post('/{message}/reply', [ClientNotificationController::class, 'reply'])->name('reply');
    });
});

/*
|--------------------------------------------------------------------------
| 3. ROUTES ADMIN (NÉCESSITENT D'ÊTRE CONNECTÉ ET ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Tableau de bord
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ====================== MODIFICATION PRINCIPALE ICI ======================
    // CRUD pour les Plats (Menu Items) avec un nom de paramètre explicite
    Route::resource('menu', AdminMenuItemController::class)->parameters([
        'menu' => 'menuItem' // Force Laravel à utiliser {menuItem} dans l'URL
    ]);
    // =======================================================================

    // Gestion des Réservations
    Route::prefix('reservations')->name('reservations.')->group(function() {
        Route::get('/', [AdminReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [AdminReservationController::class, 'show'])->name('show');
        Route::put('/{reservation}/status', [AdminReservationController::class, 'updateStatus'])->name('updateStatus');
    });

    // Gestion des Tables / Zones
    Route::get('/tables', [AdminTableController::class, 'index'])->name('tables.index');

    // Boîte de Messagerie Admin
    Route::prefix('messages')->name('messages.')->group(function() {
        Route::get('/', [AdminMessageController::class, 'index'])->name('index');
        Route::get('/create', [AdminMessageController::class, 'create'])->name('create');
        Route::get('/{message}', [AdminMessageController::class, 'show'])->name('show');
        Route::post('/{message}/reply', [AdminMessageController::class, 'reply'])->name('reply');
        // CORRECTION : J'ai décommenté et placé correctement la route 'store'
        Route::post('/', [AdminMessageController::class, 'store'])->name('store');
    });
});