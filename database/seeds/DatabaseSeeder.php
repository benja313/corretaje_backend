<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(tipo_persona::class);
        $this->call(sexo::class);
        $this->call(bancos::class);
        $this->call(tipo_cuenta_ban::class);
        $this->call(cuenta_bancaria::class);
        $this->call(caracteristicas::class);
        $this->call(tipo_propiedad::class);
        $this->call(region::class);
        $this->call(comuna::class);
        $this->call(restricciones::class);
        $this->call(tipo_publicacion::class);
        $this->call(tipo_estado_publicacion::class);
        $this->call(persona::class);
        $this->call(habitaciones::class);
        $this->call(zonas::class);

    }
}
