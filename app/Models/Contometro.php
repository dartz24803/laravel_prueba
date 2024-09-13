<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contometro extends Model
{
    use HasFactory;

    protected $table = 'contometro';
    protected $primaryKey = 'id_contometro';

    public $timestamps = false;

    protected $fillable = [
        'id_insumo',
        'id_proveedor',
        'cantidad',
        'fecha_contometro',
        'n_factura',
        'factura',
        'n_guia',
        'guia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
