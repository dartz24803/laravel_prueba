<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gravedad_Amonestacion extends Model
{
    use HasFactory;
    
    protected $table = "gravedad_amonestacion";

    protected $primaryKey = 'id_gravedad_amonestacion';

    protected $fillable = [
        'nom_gravedad_amonestacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
