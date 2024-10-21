<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaRutaTransporteTmp extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_ruta_transporte_tmp';

    public $timestamps = false;

    protected $fillable = [
        'id_caja_chica_ruta',
        'id_usuario',
        'usuario'
    ];
}
