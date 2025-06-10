@extends('layouts.app')

@section('title', 'Menu du Restaurant Riad')

@section('content')

<h2 class="page-title">Découvrez Notre Menu</h2>

<form action="{{ route('home') }}" method="GET" class="menu-search-bar">
    <input type="search" name="search" placeholder="Rechercher un plat, un ingrédient..." value="{{ request('search') }}">
    <button type="submit" class="btn"><i class="fas fa-search"></i> Rechercher</button>
</form>

@if(request('search') && $menuItemsByCategories->isEmpty())
    <div style="text-align: center; padding: 40px; background: #fff; border-radius: 8px;">
        <p>Aucun plat ne correspond à votre recherche "<strong>{{ request('search') }}</strong>".</p>
        <a href="{{ route('home') }}" class="btn" style="margin-top: 15px;">Voir tout le menu</a>
    </div>
@else
    @foreach ($menuItemsByCategories as $category => $items)
        <section class="menu-category">
            <h3>{{ $category }}</h3>
            <div class="menu-grid">
                @foreach ($items as $item)
                    <article class="menu-item-card">
                        <a href="{{ route('menu.show', $item) }}">
                            <div class="item-image" style="background-image: url('{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('placeholders/plat_placeholder.jpg') }}')"></div>
                            <div class="menu-item-content">
                                <h4>{{ $item->name }}</h4>
                                <p class="description">{{ Str::limit($item->description, 120) }}</p>
                                <p class="price">{{ number_format($item->price, 2, ',', ' ') }} DH</p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach
@endif

@endsection