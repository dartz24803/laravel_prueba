<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $table = 'modelo';
    protected $primaryKey = 'id_modelo';

    public $timestamps = false;

    protected $fillable = [
        'id_modelo_mae',
        'id_marca',
        'nom_modelo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
