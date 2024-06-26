<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';
    protected $primaryKey = 'id_cargo';

    public $timestamps = false;

    protected $fillable = [
        'id_direccion',
        'id_gerencia',
        'id_departamento',
        'id_area',
        'id_puesto',
        'nom_cargo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
