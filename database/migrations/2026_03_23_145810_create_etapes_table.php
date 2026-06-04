<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etapes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('intervention_id')
                  ->constrained('interventions')
                  ->cascadeOnDelete();

            $table->foreignId('commande_id')
                  ->constrained('commands')
                  ->restrictOnDelete();

            // Paramètre pré-choisi pour cette étape (nullable = aucun paramètre)
            $table->unsignedBigInteger('parametre_id')->nullable();
            $table->foreign('parametre_id')
                  ->references('id')
                  ->on('parametres')
                  ->nullOnDelete();

            $table->unsignedTinyInteger('position')->default(1);

            // Note contextuelle affichée à l'utilisateur pendant l'intervention
            $table->string('note', 255)->nullable();

            // Auto-référence : étape suivante selon résultat OK ou KO
            // Nullable = fin de branche
            $table->unsignedBigInteger('next_step_ok')->nullable();
            $table->unsignedBigInteger('next_step_ko')->nullable();

            $table->timestamps();

            // Index pour navigation rapide dans le graphe
            $table->index(['intervention_id', 'position']);
            $table->index('next_step_ok');
            $table->index('next_step_ko');
        });

        // FK auto-référentielles ajoutées APRÈS la création de la table
        Schema::table('etapes', function (Blueprint $table) {
            $table->foreign('next_step_ok')
                  ->references('id')
                  ->on('etapes')
                  ->nullOnDelete();

            $table->foreign('next_step_ko')
                  ->references('id')
                  ->on('etapes')
                  ->nullOnDelete();
        });

        // FK différée : interventions.first_step_id → etapes.id
        // Ajoutée ici car etapes n'existait pas encore dans la migration précédente
        Schema::table('interventions', function (Blueprint $table) {
            $table->foreign('first_step_id')
                  ->references('id')
                  ->on('etapes')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Supprimer d'abord la FK différée dans interventions
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropForeign(['first_step_id']);
        });

        // Supprimer les FK auto-référentielles avant de dropper la table
        Schema::table('etapes', function (Blueprint $table) {
            $table->dropForeign(['next_step_ok']);
            $table->dropForeign(['next_step_ko']);
        });

        Schema::dropIfExists('etapes');
    }
};