<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicacion';

    // Opcional: Si necesitas definir el nombre de la clave primaria manualmente
    protected $primaryKey = 'id_ubicacion';
    // Deshabilitamos los timestamps automáticos de Laravel
    public $timestamps = false;

    // Definimos los campos que pueden ser asignados en masa
    protected $fillable = [
        'cod_ubi',    // Código de ubicación
        'id_sede',    // ID de la sede
        'estado',     // Estado de la ubicación
        'fec_reg',    // Fecha de registro
        'user_reg',   // Usuario que registró
        'fec_act',    // Fecha de actualización
        'user_act',   // Usuario que actualizó
        'fec_eli',    // Fecha de eliminación
        'user_eli'    // Usuario que eliminó
    ];



    // Opcional: Si la clave primaria no es de tipo autoincremental, puedes definirlo aquí
    public $incrementing = true;

    // Si tu clave primaria no es un "bigint" o es de otro tipo que no sea entero
    protected $keyType = 'int';

    // Relación correcta: una ubicación pertenece a una sede laboral
    public function sede()
    {
        return $this->belongsTo(SedeLaboral::class, 'id_sede', 'id');
    }

    //NO MODIFICAR SIN COORDINACIÓN PREVIA, YA QUE SE USA EN VARIOS MÓDULOS
    public static function get_list_ubicacion_tienda()
    {
        $sql = "SELECT id_ubicacion,cod_ubi FROM ubicacion
                WHERE id_ubicacion IN (3,4,5,6,7,8,9,10,11,12,15,16,18,19)
                ORDER BY cod_ubi ASC";
        $query = DB::select($sql);
        return $query;
    }
}
