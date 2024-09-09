<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoVia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tipo_via';

    protected $primaryKey = 'id_tipo_via';

    protected $fillable = [
        'cod_tipo_via',
        'nom_tipo_via',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
