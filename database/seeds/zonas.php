<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class zonas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zonas')->insert([
            'nombre' => 'Pedro de Valdivia',
            'descripcion_zona' => 'Sector Poniente de Temuco',
            'id_comuna' => '1',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'Fundo el Carmen',
            'descripcion_zona' => 'Sector Poniente de Temuco',
            'id_comuna' => '1',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'Las Maripozas',
            'descripcion_zona' => 'Salida Norte de Temuco',
            'id_comuna' => '1',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('zonas')->insert([
            'nombre' => 'Los pablos',
            'descripcion_zona' => 'Salida Poniente de Temuco',
            'id_comuna' => '1',
            'created_at' => Carbon::now('America/Santiago')
        ]);
    }
}
