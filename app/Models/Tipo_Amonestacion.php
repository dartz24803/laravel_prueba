<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Amonestacion extends Model
{
    use HasFactory;

    protected $table = "tipo_amonestacion";
    
    protected $primaryKey = 'id_tipo_amonestacion';

    protected $fillable = [
        'nom_tipo_amonestacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
