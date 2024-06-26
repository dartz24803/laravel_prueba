<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuadroControlVisualHorario extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cuadro_control_visual_horario';

    protected $fillable = [
        'id_usuario',
        'horario',
        'dia',
        'fec_reg',
        'user_reg',
    ];
}
