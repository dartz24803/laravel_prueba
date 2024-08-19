<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';

    public $timestamps = false;

    protected $fillable = [
        'cod_servicio',
        'nom_servicio',
        'desc_servicio',
        'lectura',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
