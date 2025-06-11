<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use Illuminate\Support\Facades\File;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $imagePathPrefix = 'menu_images/';
        $storagePath = storage_path('app/public/' . $imagePathPrefix);

        if (!File::isDirectory($storagePath)) {
            File::makeDirectory($storagePath, 0755, true, true);
        }

        // --- Définition des données avec plus de catégories et de plats ---
        $platsData = [
            'Entrées & Salades' => [
                ['name' => 'Salade Marocaine Fraîcheur', 'price' => 75.00, 'description' => 'Un mélange croquant de tomates, concombres, poivrons et oignons, assaisonné à l\'huile d\'argan.', 'image' => 'salade_marocaine.jpg'],
                ['name' => 'Zaalouk d\'Aubergines Grillées', 'price' => 65.00, 'description' => 'Caviar d\'aubergines fondant, cuit avec des tomates, de l\'ail et des épices douces.', 'image' => 'zaalouk.jpg'],
                ['name' => 'Briouates au Fromage de Chèvre et Menthe', 'price' => 80.00, 'description' => 'Feuilletés croustillants farcis d\'un mélange onctueux de fromage de chèvre et de menthe fraîche.', 'image' => 'briouates_fromage.jpg'],
                ['name' => 'Soupe Harira Traditionnelle', 'price' => 70.00, 'description' => 'La soupe réconfortante par excellence, riche en lentilles, pois chiches et saveurs authentiques.', 'image' => 'harira.jpg'],
            ],
            'Plats Principaux' => [
                ['name' => 'Tajine de Poulet aux Olives et Citron Confit', 'price' => 150.00, 'description' => 'Un classique mijoté lentement pour une tendreté parfaite.', 'image' => 'tajine_poulet.jpg'],
                ['name' => 'Couscous Royal aux Sept Légumes', 'price' => 180.00, 'description' => 'Un plat généreux avec merguez, poulet et brochettes d\'agneau.', 'image' => 'couscous_royal.jpg'],
                ['name' => 'Pastilla aux Fruits de Mer', 'price' => 200.00, 'description' => 'Un feuilleté croustillant et savoureux, garni de fruits de mer frais et de vermicelles.', 'image' => 'pastilla_fruits_mer.jpg'],
                ['name' => 'Tajine d\'Agneau aux Pruneaux et Amandes', 'price' => 175.00, 'description' => 'Un délice sucré-salé, où l\'agneau fondant rencontre la douceur des pruneaux et le croquant des amandes.', 'image' => 'tajine_agneau.jpg'],
                ['name' => 'Grillade Mixte du Riad', 'price' => 170.00, 'description' => 'Un assortiment de nos meilleures viandes grillées, servies avec des sauces maison.', 'image' => 'grillade_mixte.jpg'],
                ['name' => 'Filet de Saint-Pierre à la Chérifienne', 'price' => 190.00, 'description' => 'Poisson noble cuit à la perfection, accompagné d\'une sauce tomate épicée.', 'image' => 'filet_poisson.jpg'],
                ['name' => 'Tanjia Marrakchia (sur commande)', 'price' => 220.00, 'description' => 'Viande de jarret de veau cuite lentement dans une amphore en terre avec des épices et du citron confit.', 'image' => 'tanjia.jpg'],
            ],
            'Desserts' => [
                ['name' => 'Pastilla au Lait et aux Amandes (Jawhara)', 'price' => 60.00, 'description' => 'Un dessert fin et croustillant, délicatement parfumé à la fleur d\'oranger.', 'image' => 'pastilla_lait.jpg'],
                ['name' => 'Salade d\'Oranges à la Cannelle', 'price' => 45.00, 'description' => 'Une fin de repas légère et rafraîchissante, pleine de saveurs.', 'image' => 'salade_oranges.jpg'],
                ['name' => 'Corne de Gazelle et Pâtisseries Marocaines', 'price' => 70.00, 'description' => 'Une sélection de nos meilleures pâtisseries, idéales avec un thé à la menthe.', 'image' => 'corne_de_gazelle.jpg'],
                ['name' => 'Crème Brûlée à la Fleur d\'Oranger', 'price' => 55.00, 'description' => 'Un classique revisité avec une subtile touche orientale.', 'image' => 'creme_brulee.jpg'],
                ['name' => 'Mousse au Chocolat et Amlou', 'price' => 65.00, 'description' => 'Une mousse intense au chocolat noir, rehaussée par le goût unique de l\'amlou (pâte d\'amandes et huile d\'argan).', 'image' => 'dessert_generique.jpg'],
            ],
            'Menu Enfant' => [
                ['name' => 'Mini Brochettes de Poulet avec Frites', 'price' => 80.00, 'description' => 'Des brochettes de poulet tendres et des frites croustillantes.', 'image' => 'brochettes_enfant.jpg'],
                ['name' => 'Mini Tajine de Kefta', 'price' => 90.00, 'description' => 'Boulettes de viande savoureuses dans une sauce tomate douce, sans piquant.', 'image' => 'tajine_kefta_enfant.jpg'],
                ['name' => 'Glace Vanille-Chocolat', 'price' => 40.00, 'description' => 'La douceur parfaite pour terminer le repas des petits gourmands.', 'image' => 'glace_enfant.jpg'],
            ],
             'Boissons' => [
                ['name' => 'Thé à la Menthe Fraîche', 'price' => 25.00, 'description' => 'Le symbole de l\'hospitalité marocaine, préparé dans les règles de l\'art.', 'image' => 'the_menthe.jpg'],
                ['name' => 'Jus d\'Orange Pressé', 'price' => 35.00, 'description' => 'Des oranges fraîches pressées à la minute pour un plein de vitamines.', 'image' => 'jus_orange.jpg'],
                ['name' => 'Limonade Maison au Citron et Gingembre', 'price' => 40.00, 'description' => 'Une boisson pétillante et rafraîchissante, faite maison.', 'image' => 'limonade.jpg'],
                ['name' => 'Eau Minérale Plate / Gazeuse', 'price' => 20.00, 'description' => 'Sidi Ali ou Oulmès.', 'image' => 'boisson_generique.jpg'],
            ]
        ];

        // --- Création des plats ---
        foreach ($platsData as $category => $items) {
            foreach ($items as $itemData) {
                
                $imageFinalPath = null;
                // On vérifie si une image spécifique est définie ET si le fichier existe
                if (isset($itemData['image']) && File::exists($storagePath . $itemData['image'])) {
                    $imageFinalPath = $imagePathPrefix . $itemData['image'];
                }

                MenuItem::create([
                    'name'        => $itemData['name'],
                    'description' => $itemData['description'],
                    'price'       => $itemData['price'],
                    'category'    => $category,
                    'image_path'  => $imageFinalPath,
                ]);
            }
        }
    }
}