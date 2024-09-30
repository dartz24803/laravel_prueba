<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaErrorPicking extends Model
{
    use HasFactory;

    // Define la tabla asociada
    protected $table = 'area_error_picking';

    // Define la clave primaria (si es diferente a 'id')
    protected $primaryKey = 'id';

    // Si la tabla tiene timestamps (created_at y updated_at)
    public $timestamps = false;

    // Define los campos que son asignables en masa
    protected $fillable = [
        'nombre',
    ];
}
