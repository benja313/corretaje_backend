<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    protected $fillable = [
        'video', 'titulo', 'descripcion', 'id_propiedad', 'id_estado', 'id_tipo_publi', 'id_autor', 'id_corredor'
    ];
}
