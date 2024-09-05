<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicacion';

    // Deshabilitamos los timestamps automáticos de Laravel
    public $timestamps = false;

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
        'cod_ubi',    // Código de ubicación
        'id_sede',    // ID de la sede
        'estado',     // Estado de la ubicación
        'fec_reg',    // Fecha de registro
        'user_reg',   // Usuario que registró
        'fec_act',    // Fecha de actualización
        'user_act',   // Usuario que actualizó
        'fec_eli',    // Fecha de eliminación
        'user_eli'    // Usuario que eliminó
    ];

    // Opcional: Si necesitas definir el nombre de la clave primaria manualmente
    protected $primaryKey = 'id_ubicacion';

    // Opcional: Si la clave primaria no es de tipo autoincremental, puedes definirlo aquí
    public $incrementing = true;

    // Si tu clave primaria no es un "bigint" o es de otro tipo que no sea entero
    protected $keyType = 'int';

    // Relación correcta: una ubicación pertenece a una sede laboral
    public function sede()
    {
        return $this->belongsTo(SedeLaboral::class, 'id_sede', 'id');
    }
}
