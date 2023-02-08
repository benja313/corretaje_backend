<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $fillable = [
        'id_persona','id_publicacion'
    ];
}
