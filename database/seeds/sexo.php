<?php

use Illuminate\Database\Seeder;

class sexo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sexos')->insert([
            'nombre' => 'Hombre'
        ]);
        DB::table('sexos')->insert([
            'nombre' => 'Mujer'
        ]);
        DB::table('sexos')->insert([
            'nombre' => 'Otro'
        ]);
        DB::table('sexos')->insert([
            'nombre' => 'Sin especificar'
        ]);
    }
}
