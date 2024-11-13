<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiCalendario extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'mi_calendario';

    // Llave primaria
    protected $primaryKey = 'id_calendario';

    // Desactivar timestamps automáticos
    public $timestamps = false;

    // Atributos asignables
    protected $fillable = [
        'id_usuario',
        'titulo',
        'fec_de',
        'fec_hasta',
        'descripcion',
        'id_tipo_mi_calendario',
        'invitados',
        'invitacion',
        'id_pendiente',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
}
