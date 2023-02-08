<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $fillable = [
        'nombre','descripcion'
    ];
}
