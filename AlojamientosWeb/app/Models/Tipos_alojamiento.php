<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipos_alojamiento extends Model
{

    protected $table = 'tipos_alojamientos';

    protected $fillable = [
        'nombre_alojamiento'
    ];

    public function alojamientos(){
        return $this->hasMany(Alojamiento::class, 'id_tipo_alojamiento');
    }
}
