<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoVivienda extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tipo_vivienda';

    protected $primaryKey = 'id_tipo_vivienda';

    protected $fillable = [
        'cod_tipo_vivienda',
        'nom_tipo_vivienda',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
