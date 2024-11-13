<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoTemporalPendiente extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'archivo_temporal_pendiente';

    // Llave primaria
    protected $primaryKey = 'id';

    // Desactivar timestamps automáticos (si no se usan los campos created_at y updated_at)
    public $timestamps = false;

    // Atributos asignables
    protected $fillable = [
        'ruta',
        'id_usuario'
    ];

}
