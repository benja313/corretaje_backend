<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('rut')->required()->unique();
            $table->string('nombres')->required();
            $table->string('apellido_p')->required();
            $table->string('apellido_m')->required();
            $table->string('email')->required()->unique();
            $table->string('descripcion')->nullable();
            $table->timestamp('fecha_naci')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telefono')->required();
            $table->string('password')->required();
            $table->rememberToken();
            $table->integer('id_sexo')->unsigned()->required();
            $table->integer('id_tipo_persona')->unsigned()->default(1);
            $table->integer('cuenta_bancaria')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('id_sexo')->references('id')->on('sexos')->onUpdate('cascade');
            $table->foreign('id_tipo_persona')->references('id')->on('tipo_personas')->onUpdate('cascade');
            $table->foreign('cuenta_bancaria')->references('id')->on('cuenta_bancarias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
