@extends('layouts.app')

@section('title', 'Mes Réservations')

@section('content')

<style>
    .reservation-list-item {
        background-color: #fff;
        border: 1px solid #eaeaea;
        border-left: 6px solid #8c6e4f; /* Accent par défaut */
        border-radius: 8px;
        padding: 20px 25px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s ease;
    }
    .reservation-list-item:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    /* Couleurs de bordure en fonction du statut */
    .reservation-list-item.status-confirmed { border-left-color: #5cb85c; }
    .reservation-list-item.status-pending { border-left-color: #f0ad4e; }
    .reservation-list-item.status-refused { border-left-color: #d9534f; }

    .reservation-details h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: #333;
        margin-bottom: 10px;
    }
    .reservation-details p {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 5px;
        line-height: 1.6;
    }
    .reservation-details p i.fa-fw {
        margin-right: 8px;
        color: #8c6e4f;
    }
    .reservation-actions {
        text-align: right;
    }
    .reservation-actions .btn {
        margin-top: 10px;
        font-size: 0.85rem;
        padding: 8px 15px;
    }
    .status-text {
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 15px;
        color: #fff;
        font-size: 0.8rem;
    }
    .status-confirmed .status-text { background-color: #5cb85c; }
    .status-pending .status-text { background-color: #f0ad4e; color: #333; }
    .status-refused .status-text { background-color: #d9534f; }
</style>

<h2 class="page-title">Mes Réservations</h2>

@if($reservations->isEmpty())
    <div style="text-align: center; padding: 40px; background: #fff; border-radius: 8px;">
        <p>Vous n'avez aucune réservation pour le moment.</p>
        <a href="{{ route('client.reservations.create') }}" class="btn" style="margin-top: 15px;">
            <i class="fas fa-plus"></i> Faire ma première réservation
        </a>
    </div>
@else
    <div class="reservations-list">
        @foreach($reservations as $reservation)
            <article class="reservation-list-item status-{{ $reservation->status }}">
                <div class="reservation-details">
                    <h4>
                        Réservation pour le {{ $reservation->reservation_date->format('l d F Y') }}
                    </h4>
                    <p><i class="fas fa-clock fa-fw"></i>Heure : <strong>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</strong></p>
                    <p><i class="fas fa-users fa-fw"></i>Nombre de convives : <strong>{{ $reservation->guests }}</strong></p>
                    <p><i class="fas fa-info-circle fa-fw"></i>Statut : <span class="status-text">{{ ucfirst($reservation->status) }}</span></p>
                    @if($reservation->status == 'confirmed' && $reservation->table)
                        <p><i class="fas fa-chair fa-fw"></i>Table assignée : <strong>{{ $reservation->table->name }} ({{ $reservation->table->zone }})</strong></p>
                    @endif
                </div>
                <div class="reservation-actions">
                    {{-- Le bouton de téléchargement n'apparaît que si la réservation est confirmée --}}
                    @if($reservation->status == 'confirmed')
                        <a href="{{ route('client.reservations.downloadPdf', $reservation) }}" class="btn">
                            <i class="fas fa-print"></i> Télécharger le Billet
                        </a>
                    @else
                        {{-- On pourrait mettre un bouton pour annuler une demande en attente --}}
                        <p style="font-size: 0.9rem; color: #888;">Aucune action requise.</p>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@endif

@endsection