<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionPendiente extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'cotizacion_pendiente';

    // Llave primaria
    protected $primaryKey = 'id';

    // Desactivar timestamps automáticos (si no se usan los campos created_at y updated_at)
    public $timestamps = false;

    // Atributos asignables
    protected $fillable = [
        'id_pendiente',
        'proveedor',
        'telefono',
        'costo',
    ];
    
}
