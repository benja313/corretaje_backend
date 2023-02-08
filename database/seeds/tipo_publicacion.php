<?php

use Illuminate\Database\Seeder;

class tipo_publicacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_publicacions')->insert([
        'nombre' => 'Venta',
        'descripcion' => 'La propiedad está en venta.'
    ]);
        DB::table('tipo_publicacions')->insert([
            'nombre' => 'Arriendo',
            'descripcion' => 'La propiedad está en arriendo.'
        ]);
        DB::table('tipo_publicacions')->insert([
            'nombre' => 'Venta o Arriendo',
            'descripcion' => 'La propiedad está en arriendo o venta.'
        ]);
    }
}
