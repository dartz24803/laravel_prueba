<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleExamenEntrenamiento extends Model
{
    use HasFactory;

    protected $table = 'detalle_examen_entrenamiento';

    public $timestamps = false;

    protected $fillable = [
        'id_examen',
        'id_pregunta',
        'respuesta'
    ];

    public static function get_list_detalle_examen_entrenamiento($dato){
        $sql = "SELECT pr.descripcion,de.respuesta,CASE WHEN pr.id_tipo = 2 THEN 
                (SELECT GROUP_CONCAT(CONCAT(pd.id, ':::', pd.opcion) SEPARATOR ',,,')
                FROM pregunta_detalle pd
                WHERE pd.id_pregunta = pr.id) ELSE NULL END AS opciones,de.id_pregunta,
                CASE WHEN pr.id_tipo=2 THEN (SELECT pd.id FROM pregunta_detalle pd
                WHERE pd.id_pregunta=de.id_pregunta AND pd.respuesta=1) ELSE NULL END AS respuesta_correcta
                FROM detalle_examen_entrenamiento de
                LEFT JOIN pregunta pr ON de.id_pregunta=pr.id
                WHERE de.id_examen=".$dato['id_examen'];
        $query = DB::select($sql);
        return $query;
    }
}
