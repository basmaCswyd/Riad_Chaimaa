<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        Table::create(['name' => 'T1', 'zone' => 'Terrasse', 'capacity' => 2]);
        Table::create(['name' => 'T2', 'zone' => 'Terrasse', 'capacity' => 4]);
        Table::create(['name' => 'T3', 'zone' => 'Terrasse', 'capacity' => 4]);
        Table::create(['name' => 'S1', 'zone' => 'Salle Principale', 'capacity' => 6]);
        Table::create(['name' => 'S2', 'zone' => 'Salle Principale', 'capacity' => 2]);
        Table::create(['name' => 'S3', 'zone' => 'Salle Principale', 'capacity' => 4]);
        Table::create(['name' => 'S4', 'zone' => 'Salle Principale', 'capacity' => 8]);
        Table::create(['name' => 'Salon Aladin', 'zone' => 'Salon Privé', 'capacity' => 12]);
        Table::create(['name' => 'Salon Jasmine', 'zone' => 'Salon Privé', 'capacity' => 10]);
    }
}