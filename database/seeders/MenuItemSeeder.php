<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platsPrincipaux = [
            ['name' => 'Tajine de Poulet aux Olives et Citron Confit', 'price' => 150.00],
            ['name' => 'Couscous Royal aux Sept Légumes', 'price' => 180.00],
            ['name' => 'Pastilla aux Fruits de Mer', 'price' => 200.00],
            ['name' => 'Grillade Mixte du Riad', 'price' => 170.00],
            ['name' => 'Filet de Saint-Pierre à la Chérifienne', 'price' => 190.00],
        ];

        $desserts = [
            ['name' => 'Pastilla au Lait et aux Amandes (Jawhara)', 'price' => 60.00],
            ['name' => 'Salade d\'Oranges à la Cannelle', 'price' => 45.00],
            ['name' => 'Corne de Gazelle et Pâtisseries Marocaines', 'price' => 70.00],
            ['name' => 'Crème Brûlée à la Fleur d\'Oranger', 'price' => 55.00],
        ];

        $menusEnfant = [
            ['name' => 'Mini Brochettes de Poulet avec Frites', 'price' => 80.00],
            ['name' => 'Mini Pizza Margarita', 'price' => 70.00],
            ['name' => 'Glace Vanille-Chocolat', 'price' => 40.00],
        ];

        foreach ($platsPrincipaux as $plat) {
            MenuItem::create([
                'name' => $plat['name'],
                'description' => 'Découvrez la saveur authentique de notre ' . strtolower($plat['name']) . ', préparé avec des ingrédients frais et des épices traditionnelles pour une expérience culinaire inoubliable.',
                'price' => $plat['price'],
                'category' => 'Plat Principal',
                'image_path' => 'placeholders/plat_placeholder.jpg', // Placeholder
            ]);
        }

        foreach ($desserts as $dessert) {
            MenuItem::create([
                'name' => $dessert['name'],
                'description' => 'Terminez votre repas en douceur avec notre délicieux ' . strtolower($dessert['name']) . ', une touche sucrée parfaite pour clore votre expérience au Riad.',
                'price' => $dessert['price'],
                'category' => 'Dessert',
                'image_path' => 'placeholders/dessert_placeholder.jpg', // Placeholder
            ]);
        }

        foreach ($menusEnfant as $menu) {
            MenuItem::create([
                'name' => $menu['name'],
                'description' => 'Un plat simple et savoureux, spécialement conçu pour faire plaisir aux plus jeunes de nos invités.',
                'price' => $menu['price'],
                'category' => 'Menu Enfant',
                'image_path' => 'placeholders/enfant_placeholder.jpg', // Placeholder
            ]);
        }
    }
}