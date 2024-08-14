<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioSugerido extends Model
{
    use HasFactory;

    protected $table = 'precio_sugerido';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'id_base',
        'precio_1',
        'precio_2',
        'precio_3',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
