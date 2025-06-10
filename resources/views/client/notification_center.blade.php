@extends('layouts.app')

@section('title', 'Ma Boîte de Messagerie')

@section('content')
<style>
    .message-list-item {
        background-color: #fff;
        border: 1px solid #eaeaea;
        border-left: 6px solid #8c6e4f;
        border-radius: 8px;
        padding: 20px 25px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
    }
    .message-list-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transform: translateY(-3px);
        border-left-color: #604933;
    }
    .message-list-item.is-closed {
        opacity: 0.6;
        background-color: #f9f9f9;
    }
    .message-details h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        color: #333;
        margin-bottom: 5px;
    }
    .message-details p {
        font-size: 0.9rem;
        color: #777;
        margin: 0;
    }
    .message-status {
        text-align: right;
    }
    .status-tag {
        font-weight: bold;
        padding: 4px 12px;
        border-radius: 15px;
        color: #fff;
        font-size: 0.8rem;
    }
    .status-open { background-color: #f0ad4e; color: #333; }
    .status-closed { background-color: #777; }
</style>

<h2 class="page-title">Boîte de Messagerie</h2>

<p style="text-align: center; max-width: 600px; margin: -20px auto 40px auto;">
    Voici l'historique de vos conversations avec notre équipe. Cliquez sur un message pour voir la conversation complète et y répondre.
</p>

@if($messages->isEmpty())
    <div style="text-align: center; padding: 40px; background: #fff; border-radius: 8px;">
        <p>Vous n'avez aucune conversation pour le moment.</p>
        <a href="{{ route('client.feedback.create') }}" class="btn" style="margin-top: 15px;">
            <i class="fas fa-paper-plane"></i> Envoyer un premier message
        </a>
    </div>
@else
    <div class="messages-list">
        @foreach($messages as $message)
            <a href="{{ route('client.notifications.show', $message) }}" class="message-list-item {{ $message->is_closed ? 'is-closed' : '' }}">
                <div class="message-details">
                    <h4>{{ $message->subject }}</h4>
                    <p>Ticket #{{ $message->ticket_id }} - Créé le {{ $message->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="message-status">
                    @if($message->is_closed)
                        <span class="status-tag status-closed">Fermé</span>
                    @else
                        <span class="status-tag status-open">Ouvert</span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endif

@endsection