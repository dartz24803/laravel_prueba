<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersHistoricoPuesto extends Model
{
    use HasFactory;

    protected $table = 'users_historico_puesto';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_direccion',
        'id_gerencia',
        'id_sub_gerencia',
        'id_area',
        'id_puesto',
        'fec_inicio',
        'con_fec_fin',
        'fec_fin',
        'id_tipo_cambio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
