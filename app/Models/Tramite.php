<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $table = 'tramite';

    protected $primaryKey = 'id_tramite';

    public $timestamps = false;

    protected $fillable = [
        'id_destino',
        'nom_tramite',
        'cantidad_uso',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
