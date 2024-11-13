<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingTransporte extends Model
{
    use HasFactory;

    protected $table = 'tracking_transporte';

    public $timestamps = false;

    protected $fillable = [
        'id_base',
        'anio',
        'semana',
        'transporte',
        'tiempo_llegada',
        'recepcion',
        'receptor',
        'tipo_pago',
        'nombre_transporte',
        'guia_transporte',
        'importe_transporte',
        'factura_transporte',
        'archivo_transporte',
        'fecha',
        'usuario'
    ];
}
