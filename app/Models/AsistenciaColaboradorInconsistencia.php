<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaColaboradorInconsistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencia_colaborador_inconsistencia';
    protected $primaryKey = 'id_asistencia_inconsistencia';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'centro_labores',
        'id_area',
        'fecha',
        'id_horario',
        'id_turno',
        'nom_horario',
        'con_descanso',
        'dia',
        'hora_entrada',
        'hora_entrada_desde',
        'hora_entrada_hasta',
        'hora_salida',
        'hora_salida_desde',
        'hora_salida_hasta',
        'hora_descanso_e',
        'hora_descanso_e_desde',
        'hora_descanso_e_hasta',
        'hora_descanso_s',
        'hora_descanso_s_desde',
        'hora_descanso_s_hasta',
        'observacion',
        'flag_ausencia',
        'tipo_inconsistencia',
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
