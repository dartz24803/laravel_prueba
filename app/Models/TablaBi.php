<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaBi extends Model
{
    use HasFactory;

    // La tabla asociada con el modelo
    protected $table = 'tablas_bi';
    protected $primaryKey = 'idtablas_bi';

    public $timestamps = false;

    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_acceso_bi_reporte',
        'estado',
        'idtablas_db',
        'cod_sistema',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fect_eli',
        'user_eli',
    ];

    // Los atributos que deben ser convertidos a tipos nativos
    protected $casts = [
        'fec_reg' => 'datetime',
        'fec_act' => 'datetime',
        'fect_eli' => 'datetime',
    ];
}
