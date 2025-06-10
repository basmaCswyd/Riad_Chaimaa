<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TableController extends Controller
{
    /**
     * Affiche l'état des tables pour une date donnée (par défaut, aujourd'hui).
     */
    public function index(Request $request)
    {
        // Valide que la date est bien une date valide, sinon utilise aujourd'hui
        $validated = $request->validate(['date' => 'nullable|date']);
        $date = isset($validated['date']) ? Carbon::parse($validated['date']) : today();

        // Récupère toutes les tables, groupées par zone
        $tablesByZone = Table::orderBy('zone')->orderBy('name')->get()->groupBy('zone');

        // Récupère toutes les réservations confirmées pour cette date
        $reservationsOnDate = Reservation::with('user')
            ->where('status', 'confirmed')
            ->whereDate('reservation_date', $date)
            ->get()
            ->keyBy('table_id'); // Clé du tableau par table_id pour un accès facile

        return view('admin.tables.index', [
            'tablesByZone' => $tablesByZone,
            'reservationsOnDate' => $reservationsOnDate,
            'selectedDate' => $date,
        ]);
    }
}