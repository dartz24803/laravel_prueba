<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclutamiento extends Model
{
    use HasFactory;

    protected $table = 'reclutamiento';
    protected $primaryKey = 'id_reclutamiento';
    public $timestamps = false;
    
    protected $fillable = [
        'cod_reclutamiento',
        'id_area',
        'id_puesto',
        'id_solicitante',
        'id_evaluador',
        'vacantes',
        'cod_base',
        'id_modalidad_laboral',
        'tipo_sueldo',
        'sueldo',
        'desde',
        'a',
        'id_asignado',
        'prioridad',
        'fec_cierre',
        'fec_termino',
        'fec_cierre_r',
        'observacion',
        'estado_reclutamiento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

}
