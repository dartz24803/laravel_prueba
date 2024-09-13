<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradoInstruccion extends Model
{
    use HasFactory;

    protected $table = 'grado_instruccion';
    protected $primaryKey = 'id_grado_instruccion';

    public $timestamps = false;

    protected $fillable = [
        'cod_grado_instruccion',
        'nom_grado_instruccion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
