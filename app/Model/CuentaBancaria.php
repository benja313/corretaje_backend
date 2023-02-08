<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $primarykey = 'numero_cuenta';
    protected $fillable = [
        'numero_cuenta','nombre_titular', 'rut', 'email', 'id_banco', 'id_tipo_cuenta'
    ];
}
