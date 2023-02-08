<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class region extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'id' => 8,
            'nombre' => 'Bio-Bio',
            'orden' => '10',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('regions')->insert([
            'id' => 9,
            'nombre' => 'Araucania',
            'orden' => '12',
            'created_at' => Carbon::now('America/Santiago')
        ]);
        DB::table('regions')->insert([
            'id' => 14,
            'nombre' => 'Los Rios',
            'orden' => '13',
            'created_at' => Carbon::now('America/Santiago')
        ]);
    }
}
