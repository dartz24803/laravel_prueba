<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvalJefeDirecto extends Model
{
    use HasFactory;

    protected $table = 'eval_jefe_directo';
    protected $primaryKey = 'id_eval_jefe_directo';

    public $timestamps = false;

    protected $fillable = [
        'id_postulante',
        'resultado',
        'observaciones',
        'eval_sicologica',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
