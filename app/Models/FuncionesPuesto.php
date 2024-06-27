<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionesPuesto extends Model
{
    use HasFactory;

    protected $table = 'funciones_puesto';
    protected $primaryKey = 'id_funcion';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'nom_funcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}