@extends('layouts.admin')

@section('title', 'Ajouter un Nouveau Plat')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus-circle"></i>
        <span>Nouveau Plat</span>
    </div>

    {{-- Affiche les erreurs de validation s'il y en a --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nom du plat</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Ex: Tajine de Poulet aux Olives">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required placeholder="Décrivez le plat, ses ingrédients principaux, etc.">{{ old('description') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="price">Prix (en €)</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" step="0.01" required placeholder="Ex: 15.50">
            </div>
            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="" disabled selected>-- Choisir une catégorie --</option>
                    <option value="Entrée" {{ old('category') == 'Entrée' ? 'selected' : '' }}>Entrée</option>
                    <option value="Plat Principal" {{ old('category') == 'Plat Principal' ? 'selected' : '' }}>Plat Principal</option>
                    <option value="Dessert" {{ old('category') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                    <option value="Boisson" {{ old('category') == 'Boisson' ? 'selected' : '' }}>Boisson</option>
                    <option value="Menu Enfant" {{ old('category') == 'Menu Enfant' ? 'selected' : '' }}>Menu Enfant</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Image du plat (optionnel)</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/png, image/jpeg, image/webp">
            <small>Taille recommandée : 800x600 pixels.</small>
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn"><i class="fas fa-save"></i> Enregistrer le Plat</button>
        </div>
    </form>
</div>
@endsection