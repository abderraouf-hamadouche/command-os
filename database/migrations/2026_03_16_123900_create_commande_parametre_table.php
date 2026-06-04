<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeParametreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_parametre', function (Blueprint $table) {
            $table->foreignId('command_id')->constrained('commands')->onDelete('cascade');
            $table->foreignId('parametre_id')->constrained('parametres')->onDelete('cascade');
            $table->smallInteger('position')->default(1);
            
            $table->primary(['command_id', 'parametre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_parametre');
    }
}
