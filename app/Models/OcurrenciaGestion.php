<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcurrenciaGestion extends Model
{
    use HasFactory;

    protected $table = 'ocurrencia_gestion';
    protected $primaryKey = 'id_gestion';

    public $timestamps = false;

    protected $fillable = [
        'nom_gestion',
        'estado',
        'fec_reg',
        'user_reg',
        'estado',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'digitos'
    ];
}
