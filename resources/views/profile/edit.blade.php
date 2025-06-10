@extends('layouts.app')

@section('title', 'Paramètres de mon Profil')

@section('content')
<h2 class="page-title">Paramètres du Profil</h2>

<div class="profile-layout">
    {{-- On utilise le style .form-elegant de notre CSS pour les cartes --}}
    <div class="form-elegant" style="max-width: none;">
        {{-- On inclut le formulaire de mise à jour des informations --}}
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="form-elegant" style="max-width: none;">
        {{-- On inclut le formulaire de mise à jour du mot de passe --}}
        @include('profile.partials.update-password-form')
    </div>

    <div class="form-elegant" style="max-width: none; background-color: #fff5f5; border: 1px solid #ef9a9a;">
        {{-- On inclut le formulaire de suppression du compte --}}
        @include('profile.partials.delete-user-form')
    </div>
</div>

{{-- Ajout d'un peu de style pour la mise en page --}}
@push('styles')
<style>
    .profile-layout {
        max-width: 800px;
        margin: 0 auto;
        display: grid;
        gap: 30px;
    }
</style>
@endpush
@endsection