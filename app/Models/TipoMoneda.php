<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMoneda extends Model
{
    use HasFactory;

    protected $table = 'tipo_moneda';
    protected $primaryKey = 'id_moneda';

    public $timestamps = false;

    protected $fillable = [
        'cod_moneda',
        'cod_sunat',
        'nom_moneda',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
