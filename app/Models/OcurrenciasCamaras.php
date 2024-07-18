<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcurrenciasCamaras extends Model
{
    use HasFactory;

    protected $table = 'ocurrencias_camaras';
    protected $primaryKey = 'id_ocurrencias_camaras';

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
