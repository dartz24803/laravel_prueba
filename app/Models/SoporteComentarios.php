<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoporteComentarios extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_comentarios';

    protected $primaryKey = 'idsoporte_comentarios';

    public $timestamps = false;

    protected $fillable = [

        'id_responsable',
        'idsoporte_solucion',
        'comentario',
        'fec_comentario',
        'user_act',
        'fec_act',
        'user_eli',
        'fec_eli',
        'estado',
    ];
}
