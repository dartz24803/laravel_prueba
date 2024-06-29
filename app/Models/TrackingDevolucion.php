<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDevolucion extends Model
{
    use HasFactory;

    protected $table = 'tracking_devolucion';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'id_producto',
        'tipo_falla',
        'cantidad',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}