<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDevolucionTemporal extends Model
{
    use HasFactory;

    protected $table = 'tracking_devolucion_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_producto',
        'tipo_falla',
        'cantidad'
    ];
}
