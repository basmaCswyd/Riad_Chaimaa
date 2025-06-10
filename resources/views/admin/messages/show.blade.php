@extends('layouts.admin')

@section('title', 'Conversation Ticket #' . $message->ticket_id)

{{-- On injecte du CSS spécifique pour le style de la conversation --}}
@push('styles')
<style>
    .conversation-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #eee;
    }
    .message-bubble {
        padding: 15px 20px;
        border-radius: 18px;
        max-width: 75%;
        line-height: 1.6;
    }
    .message-bubble .meta {
        font-size: 0.85rem;
        font-weight: bold;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
    }
    .message-bubble .meta .time {
        font-weight: normal;
        color: #777;
        font-size: 0.8rem;
    }
    /* Message du client, à gauche */
    .client-message {
        background-color: #e9ecef;
        color: #343a40;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
    /* Message de l'admin, à droite */
    .admin-message {
        background-color: #d1ecf1; /* Bleu clair info */
        color: #0c5460;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    .reply-form {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #eee;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-comments"></i>
        <span>Sujet : <strong>{{ $message->subject }}</strong></span>
    </div>
    <p>Conversation avec <strong>{{ $message->user->prenom }} {{ $message->user->nom }}</strong> (Ticket #{{ $message->ticket_id }})</p>
    
    <div class="conversation-container">
        @if($message->replies->isEmpty())
            <p style="text-align:center; color: #777;">Aucun message dans cette conversation pour le moment.</p>
        @else
            @foreach($message->replies as $reply)
                <div class="message-bubble {{ $reply->user->is_admin ? 'admin-message' : 'client-message' }}">
                    <div class="meta">
                        <div class="author">{{ $reply->user->is_admin ? 'Vous (Admin)' : $reply->user->prenom }}</div>
                        <div class="time">{{ $reply->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    {{-- nl2br permet de conserver les sauts de ligne, et e() protège contre les injections XSS --}}
                    <p class="body">{!! nl2br(e($reply->body)) !!}</p>
                </div>
            @endforeach
        @endif
    </div>

    @if(!$message->is_closed)
        <div class="reply-form">
            <h4>Répondre au client</h4>
            <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="body" class="sr-only">Votre réponse :</label> {{-- sr-only pour l'accessibilité --}}
                    <textarea name="body" id="body" rows="5" class="form-control" placeholder="Écrivez votre réponse ici..." required></textarea>
                </div>
                <div class="button-group" style="justify-content: flex-end;">
                    {{-- Formulaire pour fermer le ticket (action à implémenter dans le contrôleur si besoin) --}}
                    {{-- <form action="{{ route('admin.messages.close', $message) }}" method="POST" style="margin-right: 10px;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-secondary">Fermer le Ticket</button>
                    </form> --}}
                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Envoyer la réponse</button>
                </div>
            </form>
        </div>
    @else
        <div class="alert alert-secondary text-center mt-4" style="background: #f1f1f1; text-align:center; padding: 15px; margin-top: 30px; border-radius: 6px; font-weight: 500;">
            <i class="fas fa-lock"></i> Cette conversation est fermée.
        </div>
    @endif
</div>
@endsection