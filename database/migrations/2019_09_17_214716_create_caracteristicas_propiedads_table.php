<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicasPropiedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristicas_propiedads', function (Blueprint $table) {
            $table->integer('id_propiedad')->required()->unsigned();
            $table->integer('id_caracteristica')->required()->unsigned();
            $table->timestamps();
            $table->foreign('id_propiedad')->references('id')->on('propiedads')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_caracteristica')->references('id')->on('caracteristicas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracteristicas_propiedads');
    }
}
