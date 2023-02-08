<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'rut','nombres','apellido_p','apellido_m','email','fecha_naci','email_verified_at','telefono','password','id_sexo','id_tipo_persona','cuenta_bancaria'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
