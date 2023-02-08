<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $fillable = [
        'nombre','id_region'
    ];
}
