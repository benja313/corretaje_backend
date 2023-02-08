<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $fillable = [
        //cambiar cordenadas por dos columna, una latitud y longitud (posible)
        'direccion','latitud', 'longitud', 'metros_construidos', 'superficie_terreno','id_tipo_propiedad', 'id_zona', 'precio', 'moneda'
    ];
}
