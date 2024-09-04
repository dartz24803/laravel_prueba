<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoContrato extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'tipo_contrato';

    protected $primaryKey = 'id_tipo_contrato';
    
    protected $fillable = [
        'id_situacion_laboral',
        'nom_tipo_contrato',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
