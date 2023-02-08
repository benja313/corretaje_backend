<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoCuentaBan extends Model
{
    protected $fillable = [
        'nombre', 'descripcion'
    ];
}
