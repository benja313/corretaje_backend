<?php

use Illuminate\Database\Seeder;

class tipo_persona extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipo_personas')->insert([
            'id' => 1,
            'nombre' => 'basico'
        ]);
        DB::table('tipo_personas')->insert([
            'id' => 2,
            'nombre' => 'corredor'
        ]);
        DB::table('tipo_personas')->insert([
            'id' => 7,
            'nombre' => 'administrador'
        ]);
    }
}
