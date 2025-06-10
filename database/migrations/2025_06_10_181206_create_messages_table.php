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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->string('ticket_id')->unique(); // L'ID à 8 chiffres
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'initiateur du ticket (toujours un client)
        $table->string('subject');
        $table->boolean('is_closed')->default(false); // Pour fermer un ticket/feedback
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
