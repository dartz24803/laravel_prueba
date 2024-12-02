<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalendarioLogistico extends Model
{
    use HasFactory;

    protected $table = 'tipo_calendario_logistico';
    protected $primaryKey = 'id_tipo_calendario';

    public $timestamps = false;

    protected $fillable = [
        'nom_tipo_calendario',
        'color',
        'background',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
