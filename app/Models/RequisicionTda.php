<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisicionTda extends Model
{
    use HasFactory;

    protected $table = 'requisicion_tda';
    protected $primaryKey = 'id_requisicion';

    public $timestamps = false;

    protected $fillable = [
        'cod_requisicion',
        'fecha',
        'base',
        'id_usuario',
        'estado_registro',
        'fec_aprob',
        'user_aprob',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
