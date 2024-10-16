<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soporte';

    public $timestamps = false;

    protected $primaryKey = 'id_soporte';

    protected $fillable = [
        'id_especialidad',
        'id_area',
        'id_elemento',
        'id_asunto',
        'id_sede',
        'idsoporte_ubicacion',
        'idsoporte_ubicacion2',
        'fec_vencimiento',
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'

    ];
}
