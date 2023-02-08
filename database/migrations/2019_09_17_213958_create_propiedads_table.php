<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropiedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propiedads', function (Blueprint $table) {
            $table->Increments('id');
            $table->Biginteger('precio')->nullable()->unsigned();
            $table->string('moneda')->nullable();
            $table->string('direccion')->required();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            // $table->int('sector')->required()->unsigned();
            $table->integer('metros_construidos')->required()->unsigned();
            $table->integer('superficie_terreno')->required()->unsigned();

            $table->integer('id_tipo_propiedad')->required()->unsigned();
            $table->integer('id_zona')->required()->unsigned();
            $table->timestamps();

            $table->foreign('id_tipo_propiedad')->references('id')->on('tipo_propiedads')->onUpdate('cascade');
            $table->foreign('id_zona')->references('id')->on('zonas')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propiedads');
    }
}
