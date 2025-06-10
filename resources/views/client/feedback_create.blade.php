@extends('layouts.app')

@section('title', 'Envoyer un Feedback')

@section('content')
<h2 class="page-title">Nous Contacter</h2>

<p style="text-align: center; max-width: 700px; margin: -20px auto 40px auto;">
    Votre avis est précieux. Que ce soit une question, une suggestion ou un retour sur votre expérience,
    n'hésitez pas à nous laisser un message. Notre équipe vous répondra dans les plus brefs délais.
</p>

<form class="form-elegant" action="{{ route('client.feedback.store') }}" method="POST" style="max-width: 800px;">
    @csrf

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

    <div class="form-group">
        <label for="subject">Sujet de votre message</label>
        <input type="text" id="subject" name="subject" class="form-control" value="{{ old('subject') }}" 
               required placeholder="Ex: Question sur un plat, Retour sur mon dîner, Suggestion...">
    </div>

    <div class="form-group">
        <label for="description">Votre message</label>
        <textarea id="description" name="description" class="form-control" rows="8" required 
                  placeholder="Décrivez votre demande en détail ici...">{{ old('description') }}</textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-full-width">
            <i class="fas fa-paper-plane"></i> Envoyer mon message
        </button>
    </div>
</form>

@endsection