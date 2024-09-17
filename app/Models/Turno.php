<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Turno extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'turno';

    protected $primaryKey = 'id_turno';

    protected $fillable = [
        'base',
        'entrada',
        'salida',
        't_refrigerio',
        'ini_refri',
        'fin_refri',
        'estado_registro',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
