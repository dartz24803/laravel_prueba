<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    use HasFactory;

    protected $table = 'caja_chica';

    public $timestamps = false;

    protected $fillable = [
        'id_ubicacion',
        'id_categoria',
        'fecha',
        'id_sub_categoria',
        'id_empresa',
        'id_tipo_moneda',
        'total',
        'ruc',
        'razon_social',
        'ruta',
        'id_tipo_comprobante',
        'n_comprobante',
        'punto_partida',
        'punto_llegada',
        'comprobante',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
