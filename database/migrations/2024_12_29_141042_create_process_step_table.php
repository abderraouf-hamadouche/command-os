<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_step', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('process_id');
            $table->unsignedBigInteger('command_id');
            $table->integer('step_order');
            $table->text('comment')->nullable(); // Optional comment for the step
            $table->timestamps(); 
            
            $table->foreign('process_id')->references('id')->on('intervention')->onDelete('cascade');
            $table->foreign('command_id')->references('id')->on('command')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_step');
    }
}
