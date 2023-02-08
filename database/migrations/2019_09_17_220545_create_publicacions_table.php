<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicacions', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('video')->nullable();//ver si hay otro tipo para URLno opcional
            $table->string('titulo')->required();
            $table->text('descripcion')->nullable();
            $table->integer('id_propiedad')->required()->unsigned();
            $table->integer('id_estado')->default(4)->unsigned();
            $table->integer('id_tipo_publi')->required()->unsigned();
            $table->integer('id_autor')->required()->unsigned();
            $table->integer('id_corredor')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('id_propiedad')->references('id')->on('propiedads')->onDelete('cascade');
            $table->foreign('id_tipo_publi')->references('id')->on('tipo_publicacions')->onUpdate('cascade');
            $table->foreign('id_autor')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_corredor')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_estado')->references('id')->on('tipo_estado_publis')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicacions');
    }
}
