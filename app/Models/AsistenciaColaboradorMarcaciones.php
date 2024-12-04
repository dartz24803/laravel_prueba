<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaColaboradorMarcaciones extends Model
{
    use HasFactory;

    protected $table = 'asistencia_colaborador_marcaciones';
    protected $primaryKey = 'id_asistencia_detalle';

    public $timestamps = false;

    protected $fillable = [
        'id_asistencia_inconsistencia',
        'tipo_marcacion',
        'visible',
        'marcacion',
        'obs_marcacion',
        'id_asistencia_colaborador',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
