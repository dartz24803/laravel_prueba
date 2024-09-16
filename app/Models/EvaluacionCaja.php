<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionCaja extends Model
{
    use HasFactory;

    protected $table = 'evaluacion_caja';
    protected $primaryKey = 'id_evaluacion';

    public $timestamps = false;

    protected $fillable = [
        'base',
        'c_usua_caja',
        'c_usua_nomb',
        'h_ini',
        'h_fin',
        'c_codi_caja',
        'tiempo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
