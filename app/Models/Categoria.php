<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory; 

    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = [
        'id_area',
        'id_ubicacion',
        'nom_categoria',
        'id_categoria_mae',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
