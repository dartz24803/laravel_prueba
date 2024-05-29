<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDetalleEstado extends Model
{
    use HasFactory;

    protected $table = 'tracking_detalle_estado';

    public $timestamps = false;

    protected $fillable = [
        'id_detalle',
        'id_estado',
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
