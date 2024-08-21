<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    use HasFactory;

    protected $table = 'postulante';
    protected $primaryKey = 'id_postulante';

    public $timestamps = false;

    protected $fillable = [
        'postulante_nombres',
        'postulante_apater',
        'postulante_amater',
        'postulante_codigo',
        'postulante_password',
        'id_nivel',
        'postulante_email',
        'emailp',
        'num_celp',
        'num_fijop',
        'num_cele',
        'num_anexoe',
        'id_gerencia',
        'id_sub_gerencia',
        'id_area',
        'id_puesto',
        'id_cargo',
        'id_tipo_documento',
        'num_doc',
        'id_nacionalidad',
        'id_genero',
        'id_estado_civil',
        'foto',
        'foto_nombre',
        'ini_funciones',
        'fin_funciones',
        'observaciones',
        'dia_nac',
        'mes_nac',
        'anio_nac',
        'fec_nac',
        'situacion',
        'enfermedades',
        'alergia',
        'centro_labores',
        'id_puesto_evaluador ',
        'id_evaluador ',
        'flag_email',
        'acceso',
        'ip_acceso',
        'estado_postulacion',
        'aprobado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
