<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('command');
            $table->text('description');
            $table->json('tags')->nullable();
            $table->text('param');
            $table->text('pdescription');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commands_tables');
    }
}
