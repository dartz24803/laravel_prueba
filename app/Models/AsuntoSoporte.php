<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsuntoSoporte extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_asunto';

    // Clave primaria
    protected $primaryKey = 'idsoporte_asunto';

    // Evitar que Laravel maneje automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Definir los campos que pueden ser rellenados de forma masiva
    protected $fillable = [
        'nombre',
        'descripcion',
        'idsoporte_elemento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}