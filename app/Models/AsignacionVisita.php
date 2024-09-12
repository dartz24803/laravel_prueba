<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionVisita extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'asignacion_visita';

    // Define la clave primaria
    protected $primaryKey = 'id_asignacion_visita';

    // Indica que no se usará el manejo automático de timestamps (created_at y updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cod_asignacion',
        'id_inspector',
        'id_puesto_inspector',
        'fecha',
        'punto_partida',
        'punto_llegada',
        'tipo_punto_partida',
        'tipo_punto_llegada',
        'id_modelo',
        'id_proceso',
        'observacion_otros',
        'id_tipo_transporte',
        'costo',
        'inspector_acompaniante',
        'observacion',
        'fec_ini_visita',
        'fec_fin_visita',
        'ch_alm',
        'ini_alm',
        'fin_alm',
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
