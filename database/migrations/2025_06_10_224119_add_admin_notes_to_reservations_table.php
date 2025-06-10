<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // On ajoute la colonne 'admin_notes'
            // Elle peut être de type 'text' (pour des notes longues) et 'nullable' (car elle est optionnelle).
            // On la place après la colonne 'special_requests' si elle existe, sinon après 'status'.
            $table->text('admin_notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Cette partie permet d'annuler la migration si besoin
            $table->dropColumn('admin_notes');
        });
    }
};