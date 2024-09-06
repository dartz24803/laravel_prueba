<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaUbicacion extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'area_ubicacion';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_area_ubicacion';

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'id_ubicacion',
        'id_area',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act'
    ];

    // Indicamos si la tabla tiene campos de timestamps (created_at y updated_at)
    public $timestamps = false;

    // Relación con el modelo Area
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    // Relación con el modelo Ubicacion
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}
