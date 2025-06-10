<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord principal de l'administration.
     */
    public function index()
    {
        // Statistiques pour les cartes principales
        $pendingReservationsCount = Reservation::where('status', 'pending')->count();
        $confirmedTodayCount = Reservation::where('status', 'confirmed')->whereDate('reservation_date', today())->count();
        $totalClientsCount = User::where('is_admin', false)->count();
        $totalMenuItemsCount = MenuItem::count();

        // Récupère les 5 dernières réservations en attente pour un accès rapide
        $latestPendingReservations = Reservation::with('user') // Eager load pour éviter N+1 requêtes
            ->where('status', 'pending')
            ->latest() // Les plus récentes d'abord
            ->take(5)
            ->get();

        // Passe toutes les données à la vue
        return view('admin.dashboard', [
            'pendingReservationsCount' => $pendingReservationsCount,
            'confirmedTodayCount' => $confirmedTodayCount,
            'totalClientsCount' => $totalClientsCount,
            'totalMenuItemsCount' => $totalMenuItemsCount,
            'latestPendingReservations' => $latestPendingReservations,
        ]);
    }
}