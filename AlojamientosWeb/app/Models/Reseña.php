<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseña extends Model
{
    protected $table = 'reseñas';

    protected $fillable = [
        'id_usuario',
        'id_alojamiento',
        'puntuacion',
        'comentario',
        'fecha_comentario'
    ];

    protected $casts = [
        'fecha_comentario' => 'datetime',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function alojamiento(){
        return $this->belongsTo(Alojamiento::class, 'id_alojamiento');
    }
}
