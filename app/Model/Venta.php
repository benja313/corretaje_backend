<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'precio_transado', 'comision', 'pagado_autor','id_publicacion'
    ];
}
