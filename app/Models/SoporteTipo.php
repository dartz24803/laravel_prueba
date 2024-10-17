<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoporteTipo extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_tipo';

    // Clave primaria
    protected $primaryKey = 'idsoporte_tipo';

    // Evitar que Laravel maneje automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Definir los campos que pueden ser rellenados de forma masiva
    protected $fillable = [
        'nombre',
    ];
}
