@extends('layouts.app')

@section('title', 'Conversation Ticket #' . $message->ticket_id)

{{-- On injecte les mêmes styles de conversation que pour l'admin pour garder une cohérence --}}
@push('styles')
<style>
    .conversation-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #eee;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
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
    /* Message du client, à droite cette fois */
    .client-message {
        background-color: #e3f2fd; /* Bleu clair */
        color: #0d47a1;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    /* Message de l'admin, à gauche */
    .admin-message {
        background-color: #e9ecef;
        color: #343a40;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
    .reply-form {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #eee;
    }
</style>
@endpush

@section('content')
<h2 class="page-title">Conversation : {{ $message->subject }}</h2>

<div style="margin-bottom: 30px; text-align: center;">
    <a href="{{ route('client.notifications.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à tous mes messages
    </a>
</div>

<div class="conversation-container">
    @if($message->replies->isEmpty())
        <p style="text-align:center; color: #777;">Cette conversation est vide.</p>
    @else
        @foreach($message->replies as $reply)
            <div class="message-bubble {{ $reply->user->is_admin ? 'admin-message' : 'client-message' }}">
                <div class="meta">
                    <div class="author">{{ $reply->user->is_admin ? 'Support Riad' : 'Moi' }}</div>
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
        <h3 style="font-family: 'Playfair Display', serif; text-align: center; margin-bottom: 20px;">Ajouter une réponse</h3>
        <form action="{{ route('client.notifications.reply', $message) }}" method="POST" class="form-elegant" style="max-width:100%; box-shadow:none; padding:0;">
            @csrf
            <div class="form-group">
                <label for="body" class="sr-only">Votre réponse :</label>
                <textarea name="body" id="body" rows="5" class="form-control" placeholder="Écrivez votre réponse ici..." required></textarea>
            </div>
            <div class="form-actions" style="text-align: right;">
                <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Envoyer ma réponse</button>
            </div>
        </form>
    </div>
@else
    <div class="alert alert-secondary text-center mt-4" style="background: #f1f1f1; text-align:center; padding: 15px; margin-top: 30px; border-radius: 6px; font-weight: 500;">
        <i class="fas fa-lock"></i> Cette conversation est fermée et ne peut plus recevoir de réponses.
    </div>
@endif

@endsection