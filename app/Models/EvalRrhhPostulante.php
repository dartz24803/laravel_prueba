<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalRrhhPostulante extends Model
{
    use HasFactory;

    protected $table = 'eval_rrhh_postulante';
    protected $primaryKey = 'id_eval_rrhh_postulante';

    public $timestamps = false;

    protected $fillable = [
        'id_postulante',
        'resultado',
        'eval_sicologica',
        'observaciones',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
