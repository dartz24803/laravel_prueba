<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionLaboral extends Model
{
    use HasFactory;

    protected $table = 'situacion_laboral';

    public $timestamps = false;

    protected $primaryKey = 'id_situacion laboral';

    protected $fillable = [
        'cod_situacion_laboral',
        'nom_situacion_laboral',
        'ficha',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
