<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;

    protected $table = 'destino';

    protected $primaryKey = 'id_destino';

    public $timestamps = false;

    // Definición de los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_motivo',
        'nom_destino',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
