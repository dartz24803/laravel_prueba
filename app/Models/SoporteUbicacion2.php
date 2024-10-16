<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoporteUbicacion2 extends Model
{
    use HasFactory;

    protected $table = 'soporte_ubicacion2';

    // Opcional: Si necesitas definir el nombre de la clave primaria manualmente
    protected $primaryKey = 'idsoporte_ubicacion2';
    // Deshabilitamos los timestamps automáticos de Laravel
    public $timestamps = false;

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
        'nombre',
        'descripcion',
        'id_soporte_ubicacion1',
        'estado',
        'fec_reg',    // Fecha de registro
        'user_reg',   // Usuario que registró
        'fec_act',    // Fecha de actualización
        'user_act',   // Usuario que actualizó
        'fec_eli',    // Fecha de eliminación
        'user_eli'    // Usuario que eliminó
    ];



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