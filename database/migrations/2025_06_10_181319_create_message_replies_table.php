<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In database/migrations/xxxx_create_message_replies_table.php
public function up(): void
{
    Schema::create('message_replies', function (Blueprint $table) {
        $table->id();
        $table->foreignId('message_id')->constrained()->onDelete('cascade'); // Le ticket parent
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'auteur de la réponse (client ou admin)
        $table->text('body');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_replies');
    }
};
