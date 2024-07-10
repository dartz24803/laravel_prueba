<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $table = 'slide';

    public $timestamps = false;

    protected $primaryKey = 'id_slide';

    protected $fillable = [
        'tipo',
        'id_area',
        'base',
        'orden',
        'nom_slide',
        'titulo',
        'descripcion',
        'entrada_slide',
        'salida_slide',
        'duracion',
        'tipo_slide',
        'archivoslide',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
