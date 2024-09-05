<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleExamenEntrenamientoTmp extends Model
{
    use HasFactory;

    protected $table = 'detalle_examen_entrenamiento_tmp';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_pregunta'
    ];

    public static function get_list_detalle_examen_entrenamiento_tmp(){
        $sql = "SELECT de.id_pregunta,pr.descripcion,CASE WHEN pr.id_tipo = 2 THEN 
                (SELECT GROUP_CONCAT(CONCAT(pd.id, ':::', pd.opcion) SEPARATOR ',,,')
                FROM pregunta_detalle pd
                WHERE pd.id_pregunta = pr.id) ELSE NULL END AS opciones
                FROM detalle_examen_entrenamiento_tmp de
                LEFT JOIN pregunta pr ON de.id_pregunta=pr.id
                WHERE de.id_usuario=".session('usuario')->id_usuario;
        $query = DB::select($sql);
        return $query;
    }
}
