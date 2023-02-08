<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class caracteristicas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caracteristicas')->insert([
            'nombre' => 'Ventanas Termopanel',
            'descripcion' => 'Ventanas con aislación térmica',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Balcón',
            'descripcion' => 'Balcón',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Calefacción central',
            'descripcion' => 'Entrega una temperatura agradable y pareja en los distintos lugares de una vivienda.',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Cocina amoblada',
            'descripcion' => 'La cocina cuenta con accesorios básicos .',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Propiedad amoblada',
            'descripcion' => 'La propiedad cuenta con muebles básicos',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Electricidad incluida',
            'descripcion' => 'El costo del arriendo incluye este gasto',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Agua Incluida',
            'descripcion' => 'El costo del arriendo incluye este gasto',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Cable y/o Internet Incluida',
            'descripcion' => 'El costo del arriendo incluye este gasto',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('caracteristicas')->insert([
            'nombre' => 'Instalación de aire acondicionado',
            'descripcion' => 'La propiedad cuenta con una instalación de aire acondicionado',
            'created_at' => Carbon::now('America/Santiago')
        ]);
    }
}
