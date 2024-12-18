<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoReporteAperturaCierreTienda extends Model
{
    use HasFactory;

    protected $table = 'vw_puesto_reporte_apertura_cierre_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'nom_puesto'
    ];
}
