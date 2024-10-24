<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'especialidad';

    // Clave primaria
    protected $primaryKey = 'id';

    // Evitar que Laravel maneje automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Definir los campos que pueden ser rellenados de forma masiva
    protected $fillable = [
        'nombre',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
