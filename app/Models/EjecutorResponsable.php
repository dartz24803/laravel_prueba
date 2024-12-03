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

    public static function obtenerListadoConEspecialidad($id_asunto, $idArea = null)
    {
        $asunto = DB::table('soporte_asunto')
            ->where('idsoporte_asunto', $id_asunto)
            ->first();
        if (!$asunto) {
            return []; // Retornar un array vacío si no existe el asunto
        }
        if ($id_asunto == 245 && $idArea !== null) {
            // Usamos el parámetro $idArea directamente
            $idAreas = explode(',', $idArea);
        } else {
            // Descomponemos el campo id_area en un array
            $idAreas = explode(',', $asunto->id_area);
        }
        $idAreas = array_merge($idAreas, ["19", "22"]);
        $sql = "SELECT er.*
        FROM ejecutor_responsable er
        WHERE er.id_area IN (" . implode(',', array_fill(0, count($idAreas), '?')) . ")";
        $query = DB::select($sql, $idAreas);

        return array_values($query); // Retornar como array indexado
    }
}
