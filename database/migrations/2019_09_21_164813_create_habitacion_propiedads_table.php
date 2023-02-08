<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabitacionPropiedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitacion_propiedads', function (Blueprint $table) {
            $table->integer('id_propiedad')->required()->unsigned();
            $table->integer('id_habitacion')->required()->unsigned();
            $table->integer('cantidad')->required()->unsigned();
            $table->timestamps();
            $table->foreign('id_propiedad')->references('id')->on('propiedads')->onUpdate('cascade');
            $table->foreign('id_habitacion')->references('id')->on('habitacions')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habitacion_propiedads');
    }
}
