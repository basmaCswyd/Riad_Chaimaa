<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In database/migrations/xxxx_add_custom_fields_to_users_table.php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('nom')->after('name'); // 'name' de Breeze devient le prénom
        $table->renameColumn('name', 'prenom'); // On renomme 'name' en 'prenom' pour plus de clarté
        $table->string('num_telephone')->unique()->after('email');
        $table->year('annee_naissance')->after('num_telephone');
        $table->string('cin')->unique()->after('annee_naissance');
        $table->boolean('is_admin')->default(false)->after('id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
