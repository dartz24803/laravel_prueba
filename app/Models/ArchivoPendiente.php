<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoPendiente extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'archivo_pendiente';

    // Llave primaria de la tabla
    protected $primaryKey = 'id_archivo';

    // Deshabilitar timestamps automáticos si no están definidos en la tabla
    public $timestamps = false;

    // Definir los atributos asignables
    protected $fillable = [
        'id_pendiente',
        'archivo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
