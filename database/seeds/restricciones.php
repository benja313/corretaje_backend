<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class restricciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restriccions')->insert([
            'nombre' => 'Terreno indígena',
            'descripcion' => 'La propiedad está en un terreno indígena',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('restriccions')->insert([
            'nombre' => 'Hipoteca',
            'descripcion' => 'La propiedad esta asociada a una deuda hipotecaria',
            'created_at' => Carbon::now('America/Santiago')
        ]);


    }
}
