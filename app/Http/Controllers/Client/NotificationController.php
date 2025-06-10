<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Affiche la liste des tickets/messages de l'utilisateur.
     */
    public function index()
    {
        $messages = Auth::user()->messages()->latest()->get();
        return view('client.notification_center', compact('messages'));
    }

    /**
     * Affiche une conversation spécifique.
     */
    public function show(Message $message)
    {
        // Sécurité : S'assurer que le client ne peut voir que ses propres messages.
        if (Auth::id() !== $message->user_id) {
            abort(403);
        }

        $message->load('replies.user'); // Eager load pour la performance

        return view('client.notification_show', compact('message'));
    }

    /**
     * Ajoute une réponse du client à une conversation existante.
     */
    public function reply(Request $request, Message $message)
    {
        // Sécurité
        if (Auth::id() !== $message->user_id) {
            abort(403);
        }

        $request->validate(['body' => 'required|string|min:3']);

        $message->replies()->create([
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('client.notifications.show', $message)->with('success', 'Votre réponse a été ajoutée.');
    }
}