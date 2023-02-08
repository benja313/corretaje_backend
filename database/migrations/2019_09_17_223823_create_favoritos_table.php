<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorito', function (Blueprint $table) {
            $table->integer('id_persona')->required()->unsigned();
            $table->integer('id_publicacion')->required()->unsigned();
            $table->timestamps();

            $table->foreign('id_persona')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_publicacion')->references('id')->on('publicacions')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorito');
    }
}
