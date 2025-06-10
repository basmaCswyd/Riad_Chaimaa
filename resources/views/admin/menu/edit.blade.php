@extends('layouts.admin')

@section('title', 'Modifier le Plat')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i>
        <span>Modifier : {{ $menuItem->name }}</span>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.menu.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            {{-- Colonne de gauche pour les informations textuelles --}}
            <div>
                <div class="form-group">
                    <label for="name">Nom du plat</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $menuItem->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description', $menuItem->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="price">Prix (en €)</label>
                        <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $menuItem->price) }}" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="Entrée" {{ old('category', $menuItem->category) == 'Entrée' ? 'selected' : '' }}>Entrée</option>
                            <option value="Plat Principal" {{ old('category', $menuItem->category) == 'Plat Principal' ? 'selected' : '' }}>Plat Principal</option>
                            <option value="Dessert" {{ old('category', $menuItem->category) == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                            <option value="Boisson" {{ old('category', $menuItem->category) == 'Boisson' ? 'selected' : '' }}>Boisson</option>
                            <option value="Menu Enfant" {{ old('category', $menuItem->category) == 'Menu Enfant' ? 'selected' : '' }}>Menu Enfant</option>
                        </select>
                    </div>
                </div>
            </div>
            
            {{-- Colonne de droite pour l'image --}}
            <div>
                <div class="form-group">
                    <label for="image">Changer l'image</label>
                    <img src="{{ $menuItem->image_path ? asset('storage/' . $menuItem->image_path) : asset('placeholders/plat_placeholder.jpg') }}" 
                         alt="{{ $menuItem->name }}" 
                         style="width: 100%; height: auto; object-fit: cover; border-radius: 8px; margin-bottom: 10px; border: 1px solid #eee;">
                    
                    <input type="file" id="image" name="image" class="form-control" accept="image/png, image/jpeg, image/webp">
                    <small style="display: block; margin-top: 5px; color: #777;">Laissez ce champ vide pour conserver l'image actuelle.</small>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn"><i class="fas fa-save"></i> Enregistrer les modifications</button>
        </div>
    </form>
</div>
@endsection