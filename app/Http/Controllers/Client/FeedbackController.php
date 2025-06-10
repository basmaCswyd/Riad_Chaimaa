<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFeedbackRequest; // Assure-toi de créer ce fichier

class FeedbackController extends Controller
{
    /**
     * Affiche le formulaire de feedback.
     * Uniquement pour les utilisateurs authentifiés.
     */
    public function create()
    {
        return view('client.feedback_create');
    }

    /**
     * Enregistre le feedback dans la base de données.
     */
    public function store(StoreFeedbackRequest $request)
    {
        $validated = $request->validated();
        
        // Générer un ID de ticket unique à 8 chiffres
        $ticketId = mt_rand(10000000, 99999999);
        while (Message::where('ticket_id', $ticketId)->exists()) {
            $ticketId = mt_rand(10000000, 99999999);
        }

        // Créer le ticket principal
        $message = Message::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
        ]);

        // Enregistrer le premier message (la description) comme une réponse
        $message->replies()->create([
            'user_id' => Auth::id(),
            'body' => $validated['description'],
        ]);

        // Rediriger vers la boîte de messagerie avec un message de succès
        return redirect()->route('client.notifications.index')
                         ->with('success', 'Votre message (Ticket #' . $ticketId . ') a bien été envoyé !');
    }
}