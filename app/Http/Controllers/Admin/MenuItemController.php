<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;  // Assure-toi de créer ce fichier
use App\Http\Requests\UpdateMenuItemRequest;  // Assure-toi de créer ce fichier
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    /**
     * Affiche la liste de tous les plats, groupés par catégorie.
     */
    public function index()
    {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get()->groupBy('category');
        return view('admin.menu.index', compact('menuItems'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau plat.
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Enregistre un nouveau plat dans la base de données.
     */
    public function store(StoreMenuItemRequest $request)
    {
        $validatedData = $request->validated();
        
        if ($request->hasFile('image')) {
            // Stocke l'image et récupère son chemin
            // Assure-toi d'exécuter `php artisan storage:link`
            $path = $request->file('image')->store('menu_images', 'public');
            $validatedData['image_path'] = $path;
        }

        MenuItem::create($validatedData);

        return redirect()->route('admin.menu.index')->with('success', 'Le plat a été ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un plat spécifique.
     */
    public function show(MenuItem $menuItem)
    {
        // Cette méthode peut être utilisée si tu as une page de détail admin, sinon elle est optionnelle.
        return view('admin.menu.show', compact('menuItem'));
    }

    /**
     * Affiche le formulaire pour modifier un plat.
     */
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu.edit', compact('menuItem'));
    }

    /**
     * Met à jour un plat existant dans la base de données.
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($menuItem->image_path) {
                Storage::disk('public')->delete($menuItem->image_path);
            }
            // Stocke la nouvelle image
            $path = $request->file('image')->store('menu_images', 'public');
            $validatedData['image_path'] = $path;
        }

        $menuItem->update($validatedData);

        return redirect()->route('admin.menu.index')->with('success', 'Le plat a été mis à jour avec succès.');
    }

    /**
     * Supprime un plat de la base de données.
     */
    public function destroy(MenuItem $menuItem)
    {
        // Supprime l'image du stockage avant de supprimer l'enregistrement
        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }

        $menuItem->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Le plat a été supprimé avec succès.');
    }
}