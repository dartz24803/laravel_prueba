<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoVisita extends Model
{
    use HasFactory;

    protected $table = 'proceso_visita';
    protected $primaryKey = 'id_procesov';

    public $timestamps = false; // Si tu tabla tiene columnas de timestamp, cámbialo a true

    protected $fillable = [
        'nom_proceso',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
