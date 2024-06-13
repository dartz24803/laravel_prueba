<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenidoSeguimientoCoordinador extends Model
{
    use HasFactory;

    protected $table = 'contenido_seguimiento_coordinador';

    public $timestamps = false;

    protected $fillable = [
        'base',
        'id_area',
        'id_periocidad',
        'nom_dia_1',
        'nom_dia_2',
        'nom_dia_3',
        'dia_1',
        'dia_2',
        'dia',
        'mes',
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
