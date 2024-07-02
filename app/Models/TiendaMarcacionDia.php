<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiendaMarcacionDia extends Model
{
    use HasFactory;

    protected $table = 'tienda_marcacion_dia';
    protected $primaryKey = 'id_tienda_marcacion_dia';

    public $timestamps = false;

    protected $fillable = [
        'id_tienda_marcacion',
        'dia',
        'nom_dia',
        'hora_ingreso',
        'hora_apertura',
        'hora_cierre',
        'hora_salida'
    ];
}