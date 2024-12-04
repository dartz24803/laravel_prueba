<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    use HasFactory;

    protected $table = 'feriado';
    protected $primaryKey = 'id_feriado';

    public $timestamps = false;

    protected $fillable = [
        'id_anio',
        'fec_feriado',
        'desc_feriado',
        'id_tipo',
        'obs_feriado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
