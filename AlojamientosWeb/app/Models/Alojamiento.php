<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alojamiento extends Model
{
    protected $table = 'alojamientos';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'precio',
        'descripcion',
        'cpacidad',
        'id_tipo_alojamiento',
        'imagen',
    ];

    public function tipoAlojamiento() {
        return $this->belongsTo(Tipos_alojamiento::class, 'id_tipo_alojamiento');
    }

    public function reservas(){
        return $this->hasMany(Reserva::class, 'id_alojamiento');
    }

    public function reseñas(){
        return $this->hasMany(Reseña::class, 'id_alojamiento');
    }
}
