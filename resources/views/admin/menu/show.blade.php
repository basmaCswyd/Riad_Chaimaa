@extends('layouts.admin')

@section('title', 'Détail du Plat : ' . $menuItem->name)

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-eye"></i>
        <span>Détail du Plat</span>
        
        {{-- Boutons d'action rapides dans le header --}}
        <div class="action-buttons" style="margin-left: auto;">
            {{-- CORRECTION : On passe explicitement le paramètre 'menu' --}}
            <a href="{{ route('admin.menu.edit', ['menu' => $menuItem]) }}" class="btn btn-sm btn-info" title="Modifier">
                <i class="fas fa-edit"></i> Modifier
            </a>

            {{-- CORRECTION : On passe explicitement le paramètre 'menu' --}}
            <form action="{{ route('admin.menu.destroy', ['menu' => $menuItem]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce plat ?');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
        {{-- Colonne de gauche pour l'image --}}
        <div>
            <img src="{{ $menuItem->image_path ? asset('storage/' . $menuItem->image_path) : asset('placeholders/plat_placeholder.jpg') }}" 
                 alt="{{ $menuItem->name }}" 
                 style="width: 100%; height: auto; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
        </div>

        {{-- Colonne de droite pour les informations --}}
        <div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 2rem; margin-top: 0; margin-bottom: 10px;">
                {{ $menuItem->name }}
            </h3>

            <div style="margin-bottom: 20px;">
                <span style="display: inline-block; background-color: #f0f0f0; padding: 5px 15px; border-radius: 15px; font-size: 0.9rem; font-weight: 500;">
                    Catégorie : <strong>{{ $menuItem->category }}</strong>
                </span>
                <span style="display: inline-block; background-color: #fdf8f3; color: #8c6e4f; padding: 5px 15px; border-radius: 15px; font-size: 0.9rem; font-weight: 500; margin-left: 10px;">
                    Prix : <strong>{{ number_format($menuItem->price, 2, ',', ' ') }} €</strong>
                </span>
            </div>

            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Description</h4>
            <p style="line-height: 1.7;">
                {{ $menuItem->description }}
            </p>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; text-align: right;">
                <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste des plats
                </a>
            </div>
        </div>
    </div>
</div>
@endsection