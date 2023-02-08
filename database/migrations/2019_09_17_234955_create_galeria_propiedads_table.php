<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGaleriaPropiedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeria_propiedads', function (Blueprint $table) {
            $table->integer('id_propiedad')->required()->unsigned();
            $table->string('url')->required();
            $table->boolean('principal')->default(false)->required();
            $table->timestamps();
            $table->foreign('id_propiedad')->references('id')->on('propiedads')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galeria_propiedads');
    }
}
