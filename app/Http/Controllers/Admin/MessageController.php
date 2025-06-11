<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Affiche la liste de tous les tickets de messagerie.
     */
    public function index()
    {
        $messages = Message::with('user')->latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Affiche un ticket de messagerie et toutes ses réponses.
     */
    public function show(Message $message)
    {
        // Eager load les relations pour la performance
        $message->load(['user', 'replies.user']);
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Enregistre la réponse de l'admin à un ticket.
     */
    public function reply(Request $request, Message $message)
    {
        $request->validate(['body' => 'required|string|min:10']);

        $message->replies()->create([
            'user_id' => Auth::id(), // L'ID de l'admin connecté
            'body' => $request->input('body'),
        ]);

        // Optionnel : notifier l'utilisateur qu'il a reçu une réponse
        // $message->user->notify(new NewAdminReply($message));

        return redirect()->route('admin.messages.show', $message)->with('success', 'Votre réponse a été envoyée.');
    }

    /**
     * Affiche le formulaire pour créer un nouveau message vers un client.
     */
    public function create(Request $request)
    {
        $clients = User::where('is_admin', false)->orderBy('prenom')->get();
        // Pré-remplir si on vient d'un refus de réservation
        $preselectedUserId = $request->query('user_id');
        $refusalFor = $request->query('refusal_for');

        return view('admin.messages.create', compact('clients', 'preselectedUserId', 'refusalFor'));
    }


        public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|min:5|max:255',
            'body'    => 'required|string|min:10',
        ]);

        // Générer un ID de ticket unique
        $ticketId = mt_rand(10000000, 99999999);
        while (Message::where('ticket_id', $ticketId)->exists()) {
            $ticketId = mt_rand(10000000, 99999999);
        }

        // Créer le ticket/message principal
        $message = Message::create([
            'ticket_id' => $ticketId,
            'user_id'   => $validated['user_id'], // Le client sélectionné
            'subject'   => $validated['subject'],
        ]);

        // Enregistrer le premier message (celui de l'admin) comme une réponse
        $message->replies()->create([
            'user_id' => Auth::id(), // L'admin actuellement connecté
            'body'    => $validated['body'],
        ]);

        return redirect()->route('admin.messages.show', $message)
                         ->with('success', 'Le message a bien été envoyé au client.');
    }
    // Tu aurais aussi besoin d'une méthode store() pour gérer l'envoi du formulaire de 'create'
}