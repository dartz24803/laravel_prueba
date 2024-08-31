<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesosHistorial extends Model
{
    use HasFactory;

    protected $table = 'portal_procesos_historial';
    protected $primaryKey = 'id_portal_historial';

    public $timestamps = false;

    protected $fillable = [
        'id_portal',
        'codigo',
        'numero',
        'version',
        'nombre',
        'id_tipo',
        'id_area',
        'fecha',
        'etiqueta',
        'descripcion',
        'id_responsable',
        'acceso',
        'acceso_area',
        'acceso_nivel',
        'acceso_gerencia',
        'acceso_base',
        'acceso_todo',
        'div_puesto',
        'div_base',
        'div_area',
        'div_nivel',
        'div_gerencia',
        'archivo',
        'archivo2',
        'archivo3',
        'archivo4',
        'archivo5',
        'user_aprob',
        'fec_aprob',
        'estado_registro',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
