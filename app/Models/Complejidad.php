<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complejidad extends Model
{
    use HasFactory;
    
    protected $table = 'complejidad';
    protected $primaryKey = 'id_complejidad';

    public $timestamps = false;

    protected $fillable = [
        'id_modulo',
        'dificultad',
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
