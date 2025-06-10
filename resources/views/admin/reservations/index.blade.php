@extends('layouts.admin')

@section('title', 'Gérer les Réservations')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-calendar-check"></i>
        <span>Toutes les Demandes de Réservation</span>
    </div>

    {{-- Tu pourrais ajouter des filtres ici (par date, par statut, etc.) --}}
    {{-- <div class="filters mb-4"> ... </div> --}}

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Date & Heure Souhaitée</th>
                    <th>Pers.</th>
                    <th>Table Assignée</th>
                    <th>Statut</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr class="{{ $reservation->reservation_date->isPast() && $reservation->status != 'confirmed' ? 'opacity-50' : '' }}">
                        <td><strong>#{{ $reservation->id }}</strong></td>
                        <td>
                            <div>{{ $reservation->user->prenom }} {{ $reservation->user->nom }}</div>
                            <small style="color: #777;">{{ $reservation->user->email }}</small>
                        </td>
                        <td>{{ $reservation->reservation_date->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                        <td>{{ $reservation->guests }}</td>
                        <td>{{ $reservation->table->name ?? '---' }}</td>
                        <td>
                            @if($reservation->status == 'pending')
                                <span class="status-badge status-pending">En attente</span>
                            @elseif($reservation->status == 'confirmed')
                                <span class="status-badge status-confirmed">Confirmée</span>
                            @else
                                <span class="status-badge status-refused">Refusée</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-edit"></i> Gérer
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 40px;">
                            Aucune réservation n'a été trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Liens de pagination générés par Laravel --}}
    <div style="margin-top: 20px;">
        {{ $reservations->links() }}
    </div>
</div>
@endsection