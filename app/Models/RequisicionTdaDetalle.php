<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisicionTdaDetalle extends Model
{
    use HasFactory;

    protected $table = 'requisicion_tda_detalle';
    protected $primaryKey = 'id_requisicion_detalle';

    public $timestamps = false;

    protected $fillable = [
        'id_requisicion',
        'stock',
        'cantidad',
        'id_producto',
        'precio',
        'total',
        'archivo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
