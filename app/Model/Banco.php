<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $fillable = [
        'nombre','rut'
    ];
    public $timestamps = false;
}
