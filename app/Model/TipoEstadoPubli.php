<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoEstadoPubli extends Model
{
    protected $fillable = [
        'nombre', 'descripcion'
    ];
}
