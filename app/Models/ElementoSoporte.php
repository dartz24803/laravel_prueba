<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementoSoporte extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_elemento';

    // Clave primaria
    protected $primaryKey = 'idsoporte_elemento';

    // Evitar que Laravel maneje automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Definir los campos que pueden ser rellenados de forma masiva
    protected $fillable = [
        'nombre',
        'descripcion',
        'id_especialidad',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
