<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPostulante extends Model
{
    use HasFactory;

    protected $table = 'historico_postulante';
    protected $primaryKey = 'id_historico_postulante';

    public $timestamps = false;

    protected $fillable = [
        'id_postulante',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
