<?php

use Illuminate\Database\Seeder;

class tipo_estado_publicacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_estado_publis')->insert([
            'nombre' => 'Activa',
            'descripcion' => 'La publicación se mostrará públicamente.'
        ]);
        DB::table('tipo_estado_publis')->insert([
            'nombre' => 'Vendida',
            'descripcion' => 'La propiedad fue vendida.'
        ]);
        DB::table('tipo_estado_publis')->insert([
            'nombre' => 'Destacada',
            'descripcion' => 'La publicación es destacada.'
        ]);
        DB::table('tipo_estado_publis')->insert([
            'nombre' => 'Desactivada',
            'descripcion' => 'La publicación no se mostrará públicamente.'
        ]);
    }
}
