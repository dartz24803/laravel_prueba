<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErroresPicking extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'error_picking';

    // Clave primaria
    protected $primaryKey = 'id';

    // Evitar que Laravel maneje automáticamente las columnas created_at y updated_at
    public $timestamps = false;

    // Definir los campos que pueden ser rellenados de forma masiva
    protected $fillable = [
        'semana',
        'pertenece',
        'encontrado',
        'id_area',
        'estilo',
        'color',
        'id_talla',
        'prendas_devueltas',
        'id_tipo_error',
        'id_responsable',
        'solucion',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Relación con el modelo de área (si existe un modelo de área)
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    // Relación con el modelo de talla (si existe un modelo de talla)
    public function talla()
    {
        return $this->belongsTo(Talla::class, 'id_talla');
    }

    // Relación con el modelo de tipo de error (si existe un modelo de tipo de error)
    public function tipoError()
    {
        return $this->belongsTo(TipoError::class, 'id_tipo_error');
    }

    // Relación con el modelo de responsable (si existe un modelo de responsable)
    public function responsable()
    {
        return $this->belongsTo(User::class, 'id_responsable');
    }
}
