<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendiente extends Model
{
    use HasFactory;

    protected $table = 'pendientes';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'cod_base',
        'cod_pendiente',
        'id_mantenimiento',
        'id_especialidad',
        'titulo',
        'id_tipo',
        'id_area',
        'id_item',
        'id_subitem',
        'dificultad',
        'id_subsubitem',
        'id_responsable',
        'costo',
        'id_prioridad',
        'descripcion',
        'comentario',
        'f_inicio',
        'fecha_vencimiento',
        'f_entrega',
        'envio_mail',
        'conforme',
        'calificacion',
        'flag_programado',
        'id_programacion',
        'equipo_i',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
