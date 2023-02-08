<?php

use Illuminate\Database\Seeder;

class tipo_propiedad extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipo_propiedads')->insert([
            'nombre' => 'Casa',
            'descripcion' => 'Propiedad con objetivo residencial.'
        ]);
        DB::table('tipo_propiedads')->insert([
            'nombre' => 'Departamento',
            'descripcion' => 'Propiedad con objetivo residencial.'
        ]);
        DB::table('tipo_propiedads')->insert([
            'nombre' => 'Oficina',
            'descripcion' => 'Propiedad con objetivo para trabajar.'
        ]);
        DB::table('tipo_propiedads')->insert([
            'nombre' => 'Bodega',
            'descripcion' => 'Propiedad especializada para almacenamiento de productos.'
        ]);
        DB::table('tipo_propiedads')->insert([
            'nombre' => 'Otro',
            'descripcion' => 'Propiedad con un propósito cualquiera.'
        ]);
    }
}
