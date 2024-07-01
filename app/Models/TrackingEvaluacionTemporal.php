<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingEvaluacionTemporal extends Model
{
    use HasFactory;

    protected $table = 'tracking_evaluacion_temporal'; 

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_devolucion',
        'aprobacion',
        'sustento_respuesta',
        'forma_proceder'
    ];
}
