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
        'codigo',
        'nom_reporte',
        'id_area',
        'iframe',
        'descripcion',
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
}
