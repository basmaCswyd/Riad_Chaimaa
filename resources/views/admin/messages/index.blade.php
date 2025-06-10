@extends('layouts.admin')

@section('title', 'Boîte de Messagerie')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-headset"></i>
        <span>Tickets de Support & Feedbacks des Clients</span>
        {{-- Tu pourrais ajouter un bouton ici pour permettre à l'admin d'initier une conversation --}}
        {{-- <a href="{{ route('admin.messages.create') }}" class="btn">
            <i class="fas fa-paper-plane"></i> Nouveau Message
        </a> --}}
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Client</th>
                    <th>Sujet</th>
                    <th>Date de Création</th>
                    <th>Statut</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    {{-- On applique un style pour griser les tickets fermés --}}
                    <tr style="{{ $message->is_closed ? 'opacity: 0.6;' : '' }}">
                        <td><strong>#{{ $message->ticket_id }}</strong></td>
                        <td>{{ $message->user->prenom }} {{ $message->user->nom }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($message->is_closed)
                                <span class="status-badge status-refused">Fermé</span>
                            @else
                                <span class="status-badge status-pending">Ouvert</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i> Voir Conversation
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 40px; color: #777;">
                            <i class="fas fa-inbox" style="font-size: 1.5rem; margin-bottom: 10px;"></i><br>
                            La boîte de messagerie est vide pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Liens de pagination si tu en as beaucoup --}}
    <div style="margin-top: 20px;">
        {{ $messages->links() }}
    </div>
</div>
@endsection