<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioPrenda extends Model
{
    use HasFactory;

    protected $table = 'cambio_prenda';
    protected $primaryKey = 'id_cambio_prenda';

    public $timestamps = false;

    protected $fillable = [
        'tipo_boleta',
        'cod_cambio',
        'base',
        'tipo_comprobante',
        'serie',
        'n_documento',
        'n_codi_arti',
        'n_cant_vent',
        'nuevo_num_comprobante',
        'nuevo_num_serie',
        'id_motivo',
        'otro',
        'nom_cliente',
        'telefono',
        'vendedor',
        'num_caja',
        'fecha',
        'hora',
        'estado_cambio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
