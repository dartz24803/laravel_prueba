<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'config';

    protected $primaryKey = 'id_config';
    
    protected $fillable = [
        'descrip_config',
        'url_config',
        'observaciones',
        'tipo',
        'icono',
        'mensaje',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
