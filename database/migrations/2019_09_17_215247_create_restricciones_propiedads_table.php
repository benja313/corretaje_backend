<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestriccionesPropiedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restricciones_propiedads', function (Blueprint $table) {
            $table->integer('id_propiedad')->required()->unsigned();
            $table->integer('id_restriccion')->required()->unsigned();
            $table->timestamps();

            $table->foreign('id_propiedad')->references('id')->on('propiedads')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_restriccion')->references('id')->on('restriccions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restricciones_propiedads');
    }
}
