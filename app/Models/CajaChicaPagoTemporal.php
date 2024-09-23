<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaPagoTemporal extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_pago_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha',
        'monto'
    ];
}
