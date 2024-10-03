<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nicho extends Model
{
    // Definir la tabla asociada al modelo
    protected $table = 'nicho';
    
    // Definir la clave primaria
    protected $primaryKey = 'id_nicho';
    public $timestamps = false;
    
    // Definir los campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'id_percha',
        'numero',
        'nom_nicho',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
