@extends('layouts.admin')

@section('title', 'Gérer les Plats')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-utensils"></i>
        <span>Liste des Plats du Menu</span>
        <a href="{{ route('admin.menu.create') }}" class="btn">
            <i class="fas fa-plus"></i> Ajouter un plat
        </a>
    </div>

    @if($menuItems->isEmpty())
        <div style="text-align: center; padding: 40px;">
            <p>Aucun plat n'a été trouvé.</p>
        </div>
    @else
        @foreach ($menuItems as $category => $items)
            <h4 style="font-family: 'Playfair Display', serif; margin-top: 25px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; font-size: 1.4rem;">
                {{ $category }}
            </h4>
            <div class="table-wrapper" style="margin-top: 15px;">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Nom du Plat</th>
                            <th>Prix</th>
                            <th style="width: 150px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{-- CORRECTION : Le lien pointe maintenant vers la page d'édition --}}
                                    <a href="{{ route('admin.menu.edit', $item) }}">
                                        <img src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('placeholders/plat_placeholder.jpg') }}" 
                                             alt="{{ $item->name }}" 
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                    </a>
                                </td>
                                <td>
                                    {{-- CORRECTION : Le lien pointe maintenant vers la page d'édition --}}
                                    <a href="{{ route('admin.menu.edit', $item) }}" style="font-weight: bold; color: #333;">{{ $item->name }}</a>
                                    <p style="font-size: 0.85rem; color: #777; max-width: 400px;">
                                        {{ Str::limit($item->description, 100) }}
                                    </p>
                                </td>
                                <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
                                <td style="text-align: right;">
                                    <div class="action-buttons">
                                        {{-- Ces liens sont corrects mais on s'assure qu'ils le restent --}}
                                        <a href="{{ route('admin.menu.edit', $item) }}" class="btn btn-sm btn-info" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce plat ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
</div>
@endsection