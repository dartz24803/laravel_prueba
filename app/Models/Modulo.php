<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'modulo';

    // Clave primaria
    protected $primaryKey = 'id_modulo';

    // Deshabilitar timestamps automáticos (created_at y updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'cod_modulo',
        'nom_modulo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

}
