<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec le menu.
     * Accessible à tous (visiteurs et utilisateurs connectés).
     */
    public function index(Request $request)
    {
        $query = MenuItem::query();

        // Gestion de la recherche
        // On vérifie si un paramètre 'search' est présent dans l'URL
        if ($search = $request->query('search')) {
            // Si oui, on filtre les résultats
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        // Récupère les plats (filtrés ou non) et les groupe par catégorie
        $menuItemsByCategories = $query->orderBy('category')->orderBy('name')->get()->groupBy('category');

        // On retourne la vue 'home' qui se trouve dans le dossier 'client'
        // et on lui passe les données nécessaires.
        return view('client.home', [
            'menuItemsByCategories' => $menuItemsByCategories,
            'searchTerm' => $search // On passe le terme recherché pour l'afficher dans la barre de recherche
        ]);
    }

    /**
     * Affiche la page de détails d'un plat spécifique.
     * Accessible à tous.
     */
    public function showMenuItem(MenuItem $menuItem)
    {
        // On pourrait aussi récupérer des suggestions de plats de la même catégorie
        $suggestedItems = MenuItem::where('category', $menuItem->category)
            ->where('id', '!=', $menuItem->id) // Exclure le plat actuel
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        // On retourne la vue 'menu_item_detail' qui se trouve dans 'client'
        return view('client.menu_item_detail', [
            'item' => $menuItem,
            'suggestedItems' => $suggestedItems
        ]);
    }

    /**
     * Affiche la page "À propos de nous".
     */
    public function about()
    {
        // On retourne la vue 'about' qui se trouve dans 'client'
        return view('client.about');
    }
}