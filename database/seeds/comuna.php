<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class comuna extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comunas')->insert([
            'nombre' => 'Temuco',
            'id_region' => '9',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('comunas')->insert([
            'nombre' => 'Padre las Casas',
            'id_region' => '9',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('comunas')->insert([
            'nombre' => 'Lautaro',
            'id_region' => '9',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('comunas')->insert([
            'nombre' => 'Villarrica',
            'id_region' => '9',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('comunas')->insert([
            'nombre' => 'Concepcion',
            'id_region' => '8',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('comunas')->insert([
            'nombre' => 'Valdivia',
            'id_region' => '14',
            'created_at' => Carbon::now('America/Santiago')
        ]);
    }
}
