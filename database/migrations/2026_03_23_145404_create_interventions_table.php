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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 150);
            $table->string('probleme', 255);
            $table->text('description')->nullable();
 
            // Pointeur vers l'étape d'entrée du graphe
            // Nullable car l'étape n'existe pas encore au moment de l'INSERT
            $table->unsignedBigInteger('first_step_id')->nullable();
 
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
