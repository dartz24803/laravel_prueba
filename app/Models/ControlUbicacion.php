<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlUbicacion extends Model
{
    // Definir la tabla asociada al modelo
    protected $table = 'control_ubicacion';

    // Definir la clave primaria
    protected $primaryKey = 'id_control_ubicacion';
    public $timestamps = false;

    // Definir los campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'cod_control',
        'id_nicho',
        'estilo',
        'fecha',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
