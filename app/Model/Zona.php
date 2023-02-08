<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $fillable = [
        'nombre','descripcion_zona','id_comuna'
    ];
}
