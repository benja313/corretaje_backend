<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //la cuenta bancaria es creada para ser asociada a un usuario. no utiliza los mismos datos del usuario en caso de que este prefiera el dinero
        //en una cuenta en la que no es titular
        Schema::create('cuenta_bancarias', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('numero_cuenta');
            $table->string('nombre_titular')->required();
            $table->string('rut')->required();
            $table->string('email')->nullable();
            $table->integer('id_banco')->unsigned()->required();
            $table->integer('id_tipo_cuenta')->unsigned()->required();
            $table->timestamps();

            $table->foreign('id_banco')->references('id')->on('bancos')->onDelete('cascade');
            $table->foreign('id_tipo_cuenta')->references('id')->on('tipo_cuenta_bans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuenta_bancarias');
    }
}
