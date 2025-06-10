<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationController extends Controller
{
    /**
     * Affiche le formulaire de création de réservation.
     * Cette méthode ne change pas.
     */
    public function create()
    {
        return view('client.reservation_create');
    }

    /**
     * NOUVELLE LOGIQUE : Retourne les tables disponibles pour un créneau donné.
     * Cette méthode sera appelée via AJAX.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request)
    {
        // Validation des données reçues de l'appel AJAX
        $validated = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|string|date_format:H:i',
            'guests'           => 'required|integer|min:1',
        ]);

        // 1. Trouver les IDs des tables déjà réservées à ce créneau exact.
        $reservedTableIds = Reservation::where('reservation_date', $validated['reservation_date'])
            ->where('reservation_time', $validated['reservation_time'])
            ->where('status', 'confirmed') // On ne compte que les réservations déjà confirmées
            ->pluck('table_id');
            
        // 2. Trouver toutes les tables qui ne sont PAS dans la liste des réservées
        //    ET qui ont une capacité suffisante pour le nombre de convives.
        $availableTables = Table::whereNotIn('id', $reservedTableIds)
            ->where('capacity', '>=', $validated['guests'])
            ->orderBy('zone')
            ->orderBy('capacity')
            ->get();

        // 3. On retourne la liste des tables disponibles au format JSON.
        //    Le JavaScript de la page de réservation s'en servira pour afficher les cartes des tables.
        return response()->json($availableTables);
    }
    
    /**
     * NOUVELLE LOGIQUE : Enregistre la réservation avec la table choisie par le client.
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReservationRequest $request)
    {
        // Le FormRequest a déjà validé les données (date, heure, invités, table_id)
        $validated = $request->validated();

        // On crée la réservation.
        $reservation = Reservation::create([
            'user_id'  => Auth::id(),
            'table_id' => $validated['table_id'], // La table que le client SOUHAITE
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'guests'   => $validated['guests'],
            
            // ==========================================================
            // === C'EST LA LIGNE LA PLUS IMPORTANTE POUR NOTRE LOGIQUE ===
            // ==========================================================
            'status'   => 'pending',   // On force le statut à "en attente"
            
        ]);
        
        // On modifie le message de succès pour que le client sache qu'il doit attendre.
        return redirect()->route('client.reservations.index')
                         ->with('success', 'Votre demande de réservation a bien été envoyée. Vous recevrez une notification dès sa validation par notre équipe.');
    }

    /**
     * Affiche la liste des réservations de l'utilisateur connecté.
     * Cette méthode ne change pas.
     */
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with('table') // Eager load pour la performance
            ->latest('reservation_date')
            ->get();
            
        return view('client.my_reservations', compact('reservations'));
    }

    /**
     * Permet à un client de télécharger le PDF de sa réservation confirmée.
     * Cette méthode ne change pas.
     */
    public function downloadPdf(Reservation $reservation)
    {
        if (auth()->id() !== $reservation->user_id || $reservation->status !== 'confirmed') {
            abort(403, 'Action non autorisée.');
        }

        $pdf = Pdf::loadView('pdf.reservation_ticket', compact('reservation'));
        
        $fileName = 'reservation-riad-' . $reservation->id . '.pdf';

        return $pdf->download($fileName);
    }
}