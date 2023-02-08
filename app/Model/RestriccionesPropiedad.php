<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RestriccionesPropiedad extends Model
{
    protected $fillable = [
        'id_propiedad','id_restriccion'
    ];
}
