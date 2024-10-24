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

    public static function obtenerListadoConEspecialidad($id_asunto)
    {
        // Primero, obtenemos las áreas relacionadas con el id_especialidad
        $asunto = DB::table('soporte_asunto')
            ->where('idsoporte_asunto', $id_asunto)
            ->first();

        // Descomponemos el campo id_area en un array
        $idAreas = explode(',', $asunto->id_area);
        // dd($idAreas);
        $idAreas = array_merge($idAreas, ["19", "22"]); // PARA AGREGAR A LA LISTA (BASE Y TERCEROS)
        // Construimos la consulta para ejecutar contra los ids descompuestos
        $sql = "SELECT er.*
            FROM ejecutor_responsable er
            WHERE er.id_area IN (" . implode(',', array_fill(0, count($idAreas), '?')) . ")";
        // Ejecutar la consulta con los ids descompuestos
        $query = DB::select($sql, $idAreas);

        return array_values($query); // Retornar como array indexado
    }
}
