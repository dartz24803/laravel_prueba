<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoErrorPicking extends Model
{
    use HasFactory;

    // Define la tabla asociada
    protected $table = 'tipo_error_picking';

    // Define la clave primaria
    protected $primaryKey = 'id';

    // Si la tabla tiene timestamps
    public $timestamps = false;

    // Define los campos que son asignables en masa
    protected $fillable = [
        'nombre',
    ];
}
