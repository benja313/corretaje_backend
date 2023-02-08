<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HabitacionPropiedad extends Model
{
    protected $fillable = [
        'id_propiedad','id_habitacion', 'cantidad'
    ];
}
