<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GaleriaPropiedad extends Model
{
    protected $fillable = [
        'id_propiedad','url', 'principal'
    ];

}
