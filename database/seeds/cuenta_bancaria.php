<?php

use Illuminate\Database\Seeder;

class cuenta_bancaria extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cuenta_bancarias')->insert([
            'numero_cuenta' => '00-240-17976-05',
            'nombre_titular' => 'Benjamin Huete',
            'rut' => '18.876.279-4',
            'email' => 'b.huete01@ufromail.cl',
            'id_banco' => 1,
            'id_tipo_cuenta' => 2
        ]);
    }
}
