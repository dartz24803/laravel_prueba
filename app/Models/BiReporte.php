<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiReporte extends Model
{
    // Nombre de la tabla asociada al modelo
    protected $table = 'acceso_bi_reporte';
    protected $primaryKey = 'id_acceso_bi_reporte';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    // Definir los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nom_bi',
        'nom_intranet',
        'actividad',
        'id_area',
        'estado_valid',
        'id_usuario',
        'frecuencia_act',
        'tablas',
        'objetivo',
        'iframe',
        'acceso_todo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    // Configurar los campos de fecha
    protected $dates = [
        'fec_reg',
        'fec_act',
        'fec_eli',
    ];

    // Puedes agregar cualquier método adicional que necesites aquí
}
