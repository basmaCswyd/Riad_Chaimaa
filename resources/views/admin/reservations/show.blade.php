@extends('layouts.admin')

@section('title', 'Détail Réservation #' . $reservation->id)

@section('content')

{{-- Pop-up de confirmation pour le refus (inchangé) --}}
<div id="refusal-popup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:1050; align-items:center; justify-content:center; backdrop-filter: blur(5px);">
    <div class="card" style="max-width: 500px; animation: fadeIn 0.3s ease;">
        <h4 style="font-family: 'Playfair Display', serif;">Confirmer le Refus</h4>
        <p>Êtes-vous sûr de vouloir refuser cette réservation ? Cette action est irréversible et notifiera le client.</p>
        
        <form id="refusal-form" action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="refused">
            
            <div class="form-group" style="margin-top: 15px; padding: 10px; background: #f9f9f9; border-radius: 6px;">
                <label>
                    <input type="checkbox" name="send_message" value="yes"> 
                    Après le refus, me rediriger pour envoyer un message personnalisé au client.
                </label>
                <small style="display: block; color: #777;">Utile pour proposer une autre date ou s'excuser.</small>
            </div>

            <div class="button-group" style="justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('refusal-popup').style.display='none'">Annuler</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Oui, Refuser</button>
            </div>
        </form>
    </div>
</div>
<style> @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } } </style>

<div class="card">
    <div class="card-header">
        <i class="fas fa-concierge-bell"></i>
        <span>Gestion de la réservation de <strong>{{ $reservation->user->prenom }} {{ $reservation->user->nom }}</strong></span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Colonne de gauche: Informations sur la réservation (inchangée) -->
        <div style="padding-right: 30px; border-right: 1px solid #eee;">
            <h4 style="font-family: 'Playfair Display', serif;">Informations Client</h4>
            <p><strong>Nom :</strong> {{ $reservation->user->prenom }} {{ $reservation->user->nom }}</p>
            <p><strong>Email :</strong> <a href="mailto:{{ $reservation->user->email }}">{{ $reservation->user->email }}</a></p>
            <p><strong>Téléphone :</strong> {{ $reservation->user->num_telephone }}</p>
            <p><strong>CIN :</strong> {{ $reservation->user->cin }}</p>
            
            <hr style="margin: 20px 0;">

            <h4 style="font-family: 'Playfair Display', serif;">Détails de la Demande</h4>
            <p><strong>Date & Heure :</strong> {{ $reservation->reservation_date->format('l d F Y') }} à <strong>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</strong></p>
            <p><strong>Nombre de personnes :</strong> {{ $reservation->guests }}</p>
            <p><strong>Statut actuel :</strong> <span class="status-badge status-{{$reservation->status}}">{{ ucfirst($reservation->status) }}</span></p>
            
            {{-- MODIFICATION : On affiche la table souhaitée DANS les détails de la demande --}}
            @if ($reservation->table)
                <p><strong>Table souhaitée :</strong> <strong style="color: #8c6e4f;">{{ $reservation->table->name }} ({{ $reservation->table->zone }})</strong></p>
            @endif

            @if($reservation->admin_notes)
                <p><strong>Notes Admin :</strong> <span style="font-style:italic; color: #555;">"{{ $reservation->admin_notes }}"</span></p>
            @endif
        </div>

        <!-- Colonne de droite: Actions de l'administrateur -->
        <div>
            <h4 style="font-family: 'Playfair Display', serif;">Actions Administrateur</h4>

            {{-- =================== BLOC DE CODE MODIFIÉ =================== --}}
            @if($reservation->status == 'pending')
                
                {{-- Formulaire pour ACCEPTER la réservation --}}
                <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="confirmed">
                    {{-- On renvoie l'ID de la table que le client a choisie pour la confirmation --}}
                    <input type="hidden" name="table_id" value="{{ $reservation->table_id }}">
                    
                    <div class="form-group">
                        <label for="admin_notes"><strong>Ajouter des notes (optionnel) :</strong></label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" placeholder="Ex: Célébration d'anniversaire, client régulier..."></textarea>
                    </div>

                    <div class="button-group" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Accepter et Confirmer la Table
                        </button>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('refusal-popup').style.display='flex'">
                            <i class="fas fa-times"></i> Refuser la Demande
                        </button>
                    </div>
                </form>

                <p style="font-size: 0.9rem; color: #777; margin-top: 20px; background: #f9f9f9; padding: 10px; border-radius: 4px;">
                    <i class="fas fa-info-circle"></i> En acceptant, vous confirmez la table <strong>{{ $reservation->table->name ?? 'inconnue' }}</strong> pour ce client.
                </p>

            @elseif($reservation->status == 'confirmed')
                {{-- ... cette partie reste inchangée ... --}}
                <div style="background: #e9f5e9; padding: 20px; border-radius: 8px; text-align: center;">
                    <p style="margin: 0; font-weight: bold; color: #1b5e20;">Cette réservation est confirmée.</p>
                    <p style="margin-top: 5px;">Elle est assignée à la table : <strong>{{ $reservation->table->name ?? 'Erreur de table' }}</strong> dans la zone <strong>{{ $reservation->table->zone ?? 'inconnue' }}</strong>.</p>
                </div>
                <button type="button" class="btn btn-danger" style="margin-top: 20px;" onclick="document.getElementById('refusal-popup').style.display='flex'">
                    <i class="fas fa-ban"></i> Annuler cette réservation confirmée
                </button>
                <small style="display: block; margin-top: 5px; color: #777;">Cela la passera en statut "refusé" et libérera la table.</small>
                
            @else {{-- Statut "refused" --}}
                 {{-- ... cette partie reste inchangée ... --}}
                 <div style="background: #ffebee; padding: 20px; border-radius: 8px; text-align: center;">
                    <p style="margin: 0; font-weight: bold; color: #b71c1c;">Cette réservation a été refusée.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection