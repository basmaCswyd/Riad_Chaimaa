@extends('layouts.app')

@section('title', 'À Propos de Nous')

@section('content')
<style>
    .about-section {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }
    .about-section p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
    }
</style>

<div class="about-section">
    <h2 class="page-title">Notre Histoire</h2>
    <p>
        Bienvenue au Riad, un havre de paix où la gastronomie marocaine traditionnelle rencontre l'élégance contemporaine.
        Fondé en 2025, notre restaurant est né d'une passion pour les saveurs authentiques et l'hospitalité légendaire du Maroc.
    </p>
    <p>
        Chaque plat est une invitation au voyage, préparé avec des ingrédients frais, des épices soigneusement sélectionnées
        et des recettes transmises de génération en génération. Notre chef, Elfitah Chaimaa, met un point d'honneur
        à respecter la tradition tout en y apportant sa touche personnelle de modernité.
    </p>
    <p>
        Nous vous invitons à vous détendre dans notre décor inspiré des plus beaux riads de Marrakech et à laisser vos sens
        être transportés par une expérience culinaire inoubliable.
    </p>

    <a href="{{ route('client.reservations.create') }}" class="btn" style="margin-top: 20px;">
        Vivez l'expérience, réservez votre table
    </a>
</div>
@endsection