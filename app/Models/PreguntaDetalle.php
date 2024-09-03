<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaDetalle extends Model
{
    use HasFactory;

    protected $table = 'pregunta_detalle';

    public $timestamps = false;

    protected $fillable = [
        'id_pregunta',
        'opcion',
        'respuesta'
    ];
}
