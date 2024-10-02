<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadLogistica extends Model
{
    use HasFactory;

    protected $table = 'unidad_log';
    protected $primaryKey = 'id_unidad';

    public $timestamps = false;

    protected $fillable = [
        'cod_unidad',
        'nom_unidad',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
