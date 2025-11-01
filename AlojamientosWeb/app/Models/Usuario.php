<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'password',
        'telefono',
        'email',
        'is_superadmin'
    ];

    protected $hidden = ['password'];
    protected $casts = ['is_superadmin' => 'boolean'];

    //Mapear el campo contraseña
    /*public function getAuthPassword(){
        return $this->contraseña;
    }*/

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }

    public function reseñas(){
        return $this->hasMany(Reseña::class);
    }
}
