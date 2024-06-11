<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puesto';

    public $timestamps = false;

    protected $fillable = [
        'id_direccion',
        'id_gerencia',
        'id_departamento',
        'id_area',
        'nom_puesto',
        'proposito',
        'id_nivel',
        'id_sede_laboral',
        'perfil_infosap',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}