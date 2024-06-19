<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSeguimientoCoordinador extends Model
{
    use HasFactory;

    protected $table = 'detalle_seguimiento_coordinador';

    public $timestamps = false;

    protected $fillable = [
        'id_seguimiento_coordinador',
        'id_contenido',
        'valor'
    ];
}
