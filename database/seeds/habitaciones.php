<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class habitaciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('habitacions')->insert([
            'nombre' => 'Cocina',
            'descripcion' => 'Cocina',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('habitacions')->insert([
            'nombre' => 'Baño',
            'descripcion' => '',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('habitacions')->insert([
            'nombre' => 'Dormitorios',
            'descripcion' => '',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('habitacions')->insert([
            'nombre' => 'Lavadero',
            'descripcion' => '',
            'created_at' => Carbon::now('America/Santiago')
        ]);

    }
}
