<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id_venta');
            $table->integer('precio_transado')->required()->unsigned();
            $table->integer('comision')->required()->unsigned();
            $table->boolean('pagado_autor')->default(false)->required();
            $table->integer('id_publicacion')->required()->unsigned();
            $table->timestamps();
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
        Schema::dropIfExists('ventas');
    }
}
