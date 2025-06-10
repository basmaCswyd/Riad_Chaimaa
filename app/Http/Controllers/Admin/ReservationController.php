<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Notifications\ReservationStatusUpdated; // Assure-toi de créer cette classe
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Affiche la liste de toutes les réservations, paginée.
     */
    public function index()
    {
        $reservations = Reservation::with('user', 'table')
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->paginate(15); // Affiche 15 réservations par page

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Affiche les détails d'une réservation spécifique.
     */
    public function show(Reservation $reservation)
    {
        // Logique pour trouver les tables disponibles à ce créneau
        // NOTE : C'est une logique simplifiée. Une vraie app nécessiterait une vérification plus complexe.
        $reservedTableIds = Reservation::where('reservation_date', $reservation->reservation_date)
            ->where('reservation_time', $reservation->reservation_time)
            ->where('status', 'confirmed')
            ->pluck('table_id');
        
        $availableTables = Table::whereNotIn('id', $reservedTableIds)
            ->where('capacity', '>=', $reservation->guests)
            ->get();
        
        return view('admin.reservations.show', [
            'reservation' => $reservation,
            'availableTables' => $availableTables
        ]);
    }

    /**
     * Met à jour le statut d'une réservation (Accepter / Refuser).
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:confirmed,refused',
            'table_id' => 'required_if:status,confirmed|exists:tables,id',
            'admin_notes' => 'nullable|string',
        ]);

        $status = $request->input('status');
        $reservation->status = $status;
        
        if ($status === 'confirmed') {
            $reservation->table_id = $request->input('table_id');
        } else {
            // Si on refuse, on s'assure qu'aucune table n'est assignée
            $reservation->table_id = null;
        }

        if ($request->filled('admin_notes')) {
            $reservation->admin_notes = $request->input('admin_notes');
        }

        $reservation->save();

        // Envoyer une notification au client
        $reservation->user->notify(new ReservationStatusUpdated($reservation));

        $message = $status === 'confirmed' ? 'La réservation a été confirmée.' : 'La réservation a été refusée.';
        
        // Logique de redirection vers la messagerie si refusé
        if ($status === 'refused' && $request->input('send_message') === 'yes') {
            return redirect()->route('admin.messages.create', ['user_id' => $reservation->user_id, 'refusal_for' => $reservation->id]);
        }
        
        return redirect()->route('admin.reservations.index')->with('success', $message);
    }
}