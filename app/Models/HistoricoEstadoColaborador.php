<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoEstadoColaborador extends Model
{
    use HasFactory;

    protected $table = 'historico_estado_colaborador';

    protected $primaryKey = 'id_historico_estado_colaborador';

    public $timestamps = false;

    protected $fillable = [
        'id_historico_colaborador',
        'id_usuario',
        'fec_inicio',
        'estado_inicio_colaborador',
        'fec_fin',
        'estado_fin_colaborador',
        'id_motivo_cese',
        'observacion',
        'archivo_cese',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
