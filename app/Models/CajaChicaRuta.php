<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaRuta extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_ruta';

    public $timestamps = false;

    protected $fillable = [
        'id_caja_chica',
        'punto_salida',
        'punto_llegada',
        'transporte',
        'motivo',
        'costo'
    ];
}
