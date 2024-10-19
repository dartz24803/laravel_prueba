<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EjecutorResponsable extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'ejecutor_responsable';

    protected $primaryKey = 'idejecutor_responsable';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_area'

    ];

    public static function obtenerListadoConEspecialidad($id_especialidad)
    {
        $sql = "SELECT er.*, 
                       e.nombre as nombre_especialidad, 
                       CONCAT(er.nombre, ' - ', e.nombre) AS descripcion_completa 
                FROM ejecutor_responsable er
                INNER JOIN especialidad e 
                    ON FIND_IN_SET(e.id_area, er.id_area) > 0
                WHERE e.id = ?";

        // Ejecutar la consulta y retornar los resultados
        $query = DB::select($sql, [$id_especialidad]);
        return $query;
    }
}
