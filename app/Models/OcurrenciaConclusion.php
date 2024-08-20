<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcurrenciaConclusion extends Model
{
    use HasFactory;

    protected $table = 'conclusion';
    protected $primaryKey = 'id_conclusion';

    public $timestamps = false;

    protected $fillable = [
        'cod_conclusion',
        'nom_conclusion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'digitos'
    ];
}
