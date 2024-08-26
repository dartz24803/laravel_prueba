<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPortal extends Model
{
    use HasFactory;

    protected $table = "tipo_portal";

    protected $primaryKey = 'id_tipo_portal';

    protected $fillable = [
        'cod_tipo',
        'nom_tipo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
