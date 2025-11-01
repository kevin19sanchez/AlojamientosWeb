<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{

    protected $table = 'reservas';

    protected $fillable = [
        'id_usuario',
        'id_alojamiento',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'precio_total'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function alojamiento(){
        return $this->belongsTo(Alojamiento::class, 'id_alojamiento', 'id');
    }
}
