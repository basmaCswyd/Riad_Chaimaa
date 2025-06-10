{{-- On utilise le layout principal de l'administration --}}
@extends('layouts.admin')

{{-- On définit le titre de la page, qui sera aussi affiché dans la barre d'en-tête --}}
@section('title', 'Tableau de Bord')

{{-- Le contenu principal de la page --}}
@section('content')

{{-- On injecte du CSS spécifique à cette page pour les cartes de statistiques --}}
@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    .stat-card {
        background-color: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .stat-card .icon-wrapper {
        font-size: 1.8rem;
        color: #8c6e4f;
        margin-right: 20px;
        background-color: rgba(140, 110, 79, 0.1);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-card .stat-info .stat-value {
        font-size: 2.2rem;
        font-weight: 600;
        color: #333;
        line-height: 1.1;
    }
    .stat-card .stat-info .stat-label {
        font-size: 0.95rem;
        color: #666;
    }
</style>
@endpush

{{-- Grille des statistiques --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon-wrapper"><i class="fas fa-hourglass-half"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $pendingReservationsCount }}</div>
            <div class="stat-label">Réservations en attente</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon-wrapper" style="background-color: rgba(92, 184, 92, 0.1); color: #5cb85c;"><i class="fas fa-calendar-day"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $confirmedTodayCount }}</div>
            <div class="stat-label">Confirmées pour aujourd'hui</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon-wrapper" style="background-color: rgba(91, 192, 222, 0.1); color: #5bc0de;"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalClientsCount }}</div>
            <div class="stat-label">Clients enregistrés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon-wrapper" style="background-color: rgba(240, 173, 78, 0.1); color: #f0ad4e;"><i class="fas fa-utensils"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalMenuItemsCount }}</div>
            <div class="stat-label">Plats au menu</div>
        </div>
    </div>
</div>

{{-- Carte des dernières demandes --}}
<div class="card">
    <div class="card-header">
        <i class="fas fa-bell"></i>
        <span>Dernières Demandes de Réservation en Attente</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Date & Heure</th>
                    <th>Personnes</th>
                    <th>Demandé le</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestPendingReservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->prenom }} {{ $reservation->user->nom }}</td>
                        <td>{{ $reservation->reservation_date->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                        <td>{{ $reservation->guests }} pers.</td>
                        <td>{{ $reservation->created_at->diffForHumans() }}</td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i> Gérer
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #777;">
                            <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-bottom: 10px; color: #5cb85c;"></i><br>
                            Félicitations ! Aucune réservation n'est en attente de traitement.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection