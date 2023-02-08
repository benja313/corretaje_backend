<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $fillable = [
        'nombre','descripcion'
    ];
}
