<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivo_Amonestacion extends Model
{
    use HasFactory;
    
    protected $table = "motivo_amonestacion";

    protected $primaryKey = 'id_motivo_amonestacion';

    protected $fillable = [
        'nom_motivo_amonestacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
