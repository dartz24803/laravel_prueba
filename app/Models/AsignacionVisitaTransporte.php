<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionVisitaTransporte extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'asignacion_visita_transporte';

    // Deshabilitamos los timestamps automáticos de Laravel
    public $timestamps = false;

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
        'id_asignacion_visita',   // ID de la asignación de visita
        'id_tipo_transporte',     // ID del tipo de transporte
        'costo',                  // Costo del transporte
        'descripcion',            // Descripción
        'estado',                 // Estado de la asignación
        'fec_reg',                // Fecha de registro
        'user_reg',               // Usuario que registró
        'fec_act',                // Fecha de actualización
        'user_act',               // Usuario que actualizó
        'fec_eli',                // Fecha de eliminación
        'user_eli'                // Usuario que eliminó
    ];

    // Opcional: Si necesitas definir el nombre de la clave primaria manualmente
    protected $primaryKey = 'id_asignacion_visita_transporte';

    // Definimos que la clave primaria es autoincremental
    public $incrementing = true;

    // Especificamos que la clave primaria es de tipo entero
    protected $keyType = 'int';
}
