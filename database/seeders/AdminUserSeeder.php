<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'is_admin' => true,
            'prenom' => 'Admin',
            'nom' => 'Riad',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'), // Le mot de passe sera "admin"
            'num_telephone' => '0600000000',
            'annee_naissance' => '1990',
            'cin' => 'A123456',
            'email_verified_at' => now(), // On considère que l'email de l'admin est vérifié
        ]);
    }
}