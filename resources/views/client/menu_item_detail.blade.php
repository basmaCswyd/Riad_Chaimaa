@extends('layouts.app')

@section('title', $item->name)

@section('content')
<style>
    .item-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }
    .item-detail-image img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .item-detail-info h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    .item-detail-info .category-badge {
        display: inline-block;
        background-color: #fdf8f3;
        color: #8c6e4f;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .item-detail-info .description {
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 25px;
    }
    .item-detail-info .price {
        font-size: 2rem;
        font-weight: bold;
        color: #8c6e4f;
        margin-bottom: 30px;
    }
    .suggestions h3 {
        font-family: 'Playfair Display', serif;
        text-align: center;
        font-size: 1.8rem;
        margin-top: 80px;
        margin-bottom: 30px;
    }
    @media (max-width: 768px) {
        .item-detail-container { grid-template-columns: 1fr; }
    }
</style>

<div class="item-detail-container">
    <div class="item-detail-image">
        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('placeholders/plat_placeholder.jpg') }}" alt="{{ $item->name }}">
    </div>
    <div class="item-detail-info">
        <span class="category-badge">{{ $item->category }}</span>
        <h1>{{ $item->name }}</h1>
        <p class="description">{{ $item->description }}</p>
        <div class="price">{{ number_format($item->price, 2, ',', ' ') }} DH</div>
        <a href="{{ route('client.reservations.create') }}" class="btn">
            <i class="fas fa-calendar-alt"></i> Réserver une table pour déguster
        </a>
    </div>
</div>

@if($suggestedItems->isNotEmpty())
    <div class="suggestions">
        <h3>Vous aimerez aussi...</h3>
        {{-- On réutilise le style de la grille de la page d'accueil --}}
        <div class="menu-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
            @foreach($suggestedItems as $suggestedItem)
                <article class="menu-item-card">
                    <a href="{{ route('menu.show', $suggestedItem) }}">
                        <div class="item-image" style="background-image: url('{{ $suggestedItem->image_path ? asset('storage/' . $suggestedItem->image_path) : asset('placeholders/plat_placeholder.jpg') }}'); height: 180px;"></div>
                        <div class="menu-item-content">
                            <h4>{{ $suggestedItem->name }}</h4>
                            <p class="price">{{ number_format($suggestedItem->price, 2, ',', ' ') }} DH</p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
@endif

@endsection