<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaRutaTmp extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_ruta_tmp';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'personas',
        'punto_salida',
        'punto_llegada',
        'transporte',
        'motivo',
        'costo'
    ];
}
