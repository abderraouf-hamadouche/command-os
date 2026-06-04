<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateParametresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parametres', function (Blueprint $table) {
            $table->string('nom', 150)->after('id');
            $table->enum('type', ['flag', 'option', 'arg'])->after('nom');
            $table->text('description')->after('type');
            $table->string('argument', 150)->nullable()->after('description');
            $table->string('suffix', 150)->nullable()->after('argument');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
