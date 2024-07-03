<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CObservacionAperturaCierreTienda extends Model
{
    use HasFactory;

    protected $table = 'c_observacion_apertura_cierre_tienda';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
