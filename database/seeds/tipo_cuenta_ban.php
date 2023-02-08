<?php

use Illuminate\Database\Seeder;

class tipo_cuenta_ban extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_cuenta_bans')->insert([
            'nombre' => 'Vista',
            'descripcion' => 'Cuentas de tipo vista'
        ]);
        DB::table('tipo_cuenta_bans')->insert([
            'nombre' => 'Cuenta corriente',
            'descripcion' => 'Cuentas de tipo corriente'
        ]);
        DB::table('tipo_cuenta_bans')->insert([
            'nombre' => 'Cuenta de ahorros',
            'descripcion' => 'Cuentas de tipo ahorros'
        ]);
    }
}
