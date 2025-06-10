@extends('layouts.admin')

@section('title', 'Gestion des Tables et Zones')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-chair"></i>
        <span>Disponibilité des Tables</span>
    </div>

    {{-- Formulaire pour choisir la date. Le JS intégré recharge la page quand la date change --}}
    <form method="GET" action="{{ route('admin.tables.index') }}" style="padding: 20px 0; display: flex; align-items: flex-end; gap: 15px; border-bottom: 1px solid #eee;">
        <div class="form-group" style="margin-bottom: 0; max-width: 300px;">
            <label for="date"><strong>Afficher le statut pour la date :</strong></label>
            <input type="date" id="date" name="date" class="form-control" value="{{ $selectedDate->format('Y-m-d') }}" onchange="this.form.submit()">
        </div>
    </form>

    <h4 style="font-family: 'Playfair Display', serif; text-align:center; margin: 30px 0;">
        État des tables pour le : <strong>{{ $selectedDate->isoFormat('dddd D MMMM YYYY') }}</strong>
    </h4>

    {{-- Boucle sur chaque zone (Terrasse, Salle, etc.) --}}
    @foreach ($tablesByZone as $zone => $tables)
        <div style="margin-bottom: 30px;">
            <h5 style="padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; margin-bottom: 15px; font-size: 1.3rem; font-family: 'Playfair Display', serif;">
                Zone : {{ $zone }}
            </h5>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Table</th>
                            <th>Capacité</th>
                            <th>Statut de la Soirée</th>
                            <th>Détails de la Réservation</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Boucle sur chaque table dans la zone --}}
                        @foreach ($tables as $table)
                            <tr>
                                <td><strong>{{ $table->name }}</strong></td>
                                <td>{{ $table->capacity }} personnes</td>
                                <td>
                                    {{-- On vérifie si l'ID de cette table existe dans notre tableau de réservations --}}
                                    @if(isset($reservationsOnDate[$table->id]))
                                        {{-- Si oui, la table est réservée --}}
                                        <span style="color: #d9534f; font-weight: 500;">
                                            <i class="fas fa-lock"></i> Réservée
                                        </span>
                                    @else
                                        {{-- Sinon, elle est libre --}}
                                        <span style="color: #5cb85c; font-weight: 500;">
                                            <i class="fas fa-check-circle"></i> Libre
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{-- On affiche les détails seulement si la table est réservée --}}
                                    @if(isset($reservationsOnDate[$table->id]))
                                        @php 
                                            // On récupère la réservation associée à cette table
                                            $reservation = $reservationsOnDate[$table->id]; 
                                        @endphp
                                        <small>
                                            Par <strong>{{ $reservation->user->prenom }}</strong>
                                            à {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                                            (<a href="{{ route('admin.reservations.show', $reservation) }}" title="Voir la réservation">Voir</a>)
                                        </small>
                                    @else
                                        <small style="color: #999;">--</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection