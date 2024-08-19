<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosServicio extends Model
{
    use HasFactory;

    protected $table = 'datos_servicio';
    protected $primaryKey = 'id_datos_servicio';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'id_servicio',
        'id_proveedor_servicio',
        'id_lugar_servicio',
        'contrato_servicio',
        'medidor',
        'suministro',
        'ruta',
        'cliente',
        'doc_cliente',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
