<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionAperturaCierreTienda extends Model
{
    use HasFactory;

    protected $table = 'observacion_apertura_cierre_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_apertura_cierre',
        'tipo_apertura',
        'id_observacion'
    ];
}
