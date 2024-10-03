<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Percha extends Model
{
    // Definir la tabla asociada al modelo
    protected $table = 'percha';

    // Definir la clave primaria
    protected $primaryKey = 'id_percha';
    public $timestamps = false;

    // Definir los campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'nom_percha',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

}
