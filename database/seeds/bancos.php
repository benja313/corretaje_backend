<?php

use Illuminate\Database\Seeder;

class bancos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('bancos')->insert([
            'nombre' => 'BANCO DE CHILE',
            'rut' => ' 97.004.000-5'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO INTERNACIONAL',
            'rut' => '97.011.000-3'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'SCOTIABANK CHILE',
            'rut' => '97.018.000-1'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO DE CREDITO E INVERSIONES',
            'rut' => '97.006.000-6'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO BICE',
            'rut' => '97.080.000-K'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'HSBC BANK',
            'rut' => '97.011.000-3'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO SANTANDER-CHILE',
            'rut' => '97.036.000-k'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'ITAÚ CORPBANCA',
            'rut' => '97.023.000-9'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO SECURITY',
            'rut' => '97.053.000-2'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BBANCO FALABELLA',
            'rut' => '96.509.660–4'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO RIPLEY',
            'rut' => '97.004.000-5'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO CONSORCIO',
            'rut' => '99.500.410-0'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'SCOTIABANK AZUL',
            'rut' => '97.018.000-1'
        ]);
        DB::table('bancos')->insert([
            'nombre' => 'BANCO BTG PACTUAL CHILE',
            'rut' => '76.362.099-9'
        ]);

    }
}
