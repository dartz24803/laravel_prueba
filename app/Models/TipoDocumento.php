<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoDocumento extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'tipo_documento';

    protected $primaryKey = 'id_tipo_documento';
    
    protected $fillable = [
        'cod_tipo_documento',
        'cod_sunat',
        'nom_tipo_documento',
        'numero',
        'desc_abreviada',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'digitos',
    ];

}
