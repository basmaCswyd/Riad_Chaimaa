<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In database/migrations/xxxx_create_tables_table.php
public function up(): void
{
    Schema::create('tables', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // "Table 4", "Table VIP"
        $table->string('zone'); // "Terrasse", "Salle Principale", "Salon Privé"
        $table->integer('capacity');
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
