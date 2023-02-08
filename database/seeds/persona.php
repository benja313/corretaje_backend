<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class persona extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'rut' => '18.876.279-4',
            'nombres' => 'Benjamín Gonzalo',
            'apellido_p' => 'Huete',
            'apellido_m' => 'Nahuel',
            'email' => 'b.huete01@ufromail.cl',
            'fecha_naci' => Carbon::now('America/Santiago'),
            'password' => bcrypt('123456'),
            'telefono' => '+56961765325',
            'id_sexo' => 1,
            'id_tipo_persona' => 7,
            'cuenta_bancaria' => '1',
            'created_at' => Carbon::now('America/Santiago')
        ]);
    }
}
