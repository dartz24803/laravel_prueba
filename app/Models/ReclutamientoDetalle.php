<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReclutamientoDetalle extends Model
{
    use HasFactory;

    protected $table = 'reclutamiento_detalle';

    protected $primaryKey = 'id_reclutamiento_detalle';

    public $timestamps = false;

    protected $fillable = [
        'id_reclutamiento',
        'id_evaluador',
        'id_modalidad_laboral',
        'tipo_sueldo',
        'prioridad',
        'sueldo',
        'desde',
        'a',
        'id_asignado',
        'observacion',
        'fec_enproceso',
        'fec_cierre',
        'fec_cierre_r',
        'estado_reclutamiento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
