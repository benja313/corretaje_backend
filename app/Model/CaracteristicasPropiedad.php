<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasPropiedad extends Model
{
    protected $fillable = [
        'id_propiedad','id_caracteristica'
    ];
}
