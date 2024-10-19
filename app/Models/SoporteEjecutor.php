<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoporteEjecutor extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_ejecutor';

    protected $primaryKey = 'idsoporte_ejecutor';

    public $timestamps = false;

    protected $fillable = [
        'idejecutor_responsable',
        'fec_inicio_proyecto',
        'nombre_proyecto',
        'proveedor',
        'nombre_contratista',
        'dni_prestador_servicio',
        'ruc',
        'estado',
        'fec_reg',
        'user_reg',
        'user_act',
        'fec_act',
    ];
}
