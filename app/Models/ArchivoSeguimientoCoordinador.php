<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoSeguimientoCoordinador extends Model
{
    use HasFactory;
    
    protected $table = 'archivos_seguimiento_coordinador';

    public $timestamps = false;

    protected $fillable = [
        'id_seguimiento_coordinador',
        'archivo'
    ];
}
