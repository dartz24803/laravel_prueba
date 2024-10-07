<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pregunta extends Model
{
    use HasFactory;

    protected $table = 'pregunta';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'id_tipo',
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_cantidad_preguntas(){
        $sql = "SELECT pu.nom_puesto,(SELECT COUNT(1) FROM pregunta pe 
                WHERE pe.id_puesto=pr.id_puesto AND pe.id_tipo=1) AS abiertas,
                (SELECT COUNT(1) FROM pregunta pe 
                WHERE pe.id_puesto=pr.id_puesto AND pe.id_tipo=2) AS opcion_multiple
                FROM pregunta pr
                LEFT JOIN puesto pu ON pr.id_puesto=pu.id_puesto
                WHERE pr.estado=1
                GROUP BY pr.id_puesto,pu.nom_puesto";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_pregunta_evaluacion($dato){
        $sql = "SELECT id,descripcion FROM 
                (
                    SELECT id,descripcion FROM pregunta
                    WHERE id_puesto=".$dato['id_puesto']." AND id_tipo=1 AND estado=1
                    ORDER BY RAND()
                    LIMIT 15
                ) AS t1
                UNION ALL
                SELECT id,descripcion FROM 
                (
                    SELECT id,descripcion FROM pregunta
                    WHERE id_puesto=".$dato['id_puesto']." AND id_tipo=2 AND estado=1
                    ORDER BY RAND()
                    LIMIT 5
                ) AS t2
                ORDER BY RAND()";
        $query = DB::select($sql);
        return $query;
    }
}
