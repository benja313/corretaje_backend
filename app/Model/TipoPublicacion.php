<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoPublicacion extends Model
{
    protected $fillable = [
        'nombre', 'descripcion'
    ];
}
