<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDetalleProceso extends Model
{
    use HasFactory;

    protected $table = 'tracking_detalle_proceso';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'id_proceso',
        'fecha',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
