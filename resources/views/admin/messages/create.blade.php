@extends('layouts.admin')

@section('title', 'Envoyer un Nouveau Message')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-paper-plane"></i>
        <span>Écrire un nouveau message à un client</span>
    </div>

    {{-- Affiche les erreurs de validation s'il y en a --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="background: #ffebee; color: #b71c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <strong>Oups ! Il y a quelques erreurs :</strong>
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Le contrôleur aura besoin d'une méthode 'store' pour gérer ce formulaire --}}
    <form action="{{ route('admin.messages.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user_id">Destinataire (Client)</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Sélectionnez un client --</option>
                @foreach($clients as $client)
                    {{-- Si on vient d'un refus de réservation, le bon client sera pré-sélectionné --}}
                    <option value="{{ $client->id }}" {{ $preselectedUserId == $client->id ? 'selected' : '' }}>
                        {{ $client->prenom }} {{ $client->nom }} ({{ $client->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Sujet du message</label>
            {{-- Si on vient d'un refus, on pré-remplit le sujet --}}
            @php
                $subjectValue = old('subject');
                if ($refusalFor) {
                    $subjectValue = "Concernant votre demande de réservation #" . $refusalFor;
                }
            @endphp
            <input type="text" id="subject" name="subject" class="form-control" value="{{ $subjectValue }}" 
                   required placeholder="Ex: Concernant votre réservation, Informations importantes...">
        </div>

        <div class="form-group">
            <label for="body">Contenu du message</label>
            <textarea id="body" name="body" class="form-control" rows="8" required 
                      placeholder="Écrivez votre message ici...">{{ old('body') }}</textarea>
        </div>
        
        <div class="button-group" style="justify-content: flex-end; margin-top: 20px;">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn">
                <i class="fas fa-paper-plane"></i> Envoyer le Message
            </button>
        </div>
    </form>
</div>
@endsection