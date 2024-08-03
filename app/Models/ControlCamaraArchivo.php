<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ControlCamaraArchivo extends Model
{
    use HasFactory;

    protected $table = 'control_camara_archivo';

    public $timestamps = false;

    protected $fillable = [
        'id_control_camara',
        'id_ronda',
        'archivo'
    ];

    public static function get_list_control_camara_archivo($dato)
    {
        if(isset($dato['id'])){
            $sql = "SELECT ca.id,ca.archivo,CASE WHEN ca.id_ronda IS NULL THEN lo.descripcion
                    ELSE CONCAT(lo.descripcion,'(',cr.descripcion,')') END AS titulo,
                    CONCAT(DATE_FORMAT(cc.fecha,'%d/%m/%Y'),' ',
                    DATE_FORMAT(cc.hora_registro,'%H:%i:%s')) AS fecha
                    FROM control_camara_archivo ca
                    LEFT JOIN control_camara cc ON ca.id_control_camara=cc.id
                    LEFT JOIN local lo ON cc.id_tienda=lo.id_local
                    LEFT JOIN control_camara_ronda cr ON ca.id_ronda=cr.id
                    WHERE ca.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $parte_sede = "";
            if($dato['id_sede']!="0"){
                $parte_sede = "cc.id_sede=".$dato['id_sede']." AND";
            }
            $parte_local = "";
            if($dato['id_local']!="0"){
                $parte_local = "cc.id_tienda=".$dato['id_local']." AND";
            }
            $sql = "SELECT ca.id,ca.archivo,CASE WHEN ca.id_ronda IS NULL THEN lo.descripcion
                    ELSE CONCAT(lo.descripcion,'(',cr.descripcion,')') END AS titulo,
                    CONCAT(DATE_FORMAT(cc.fecha,'%d/%m/%Y'),' ',
                    DATE_FORMAT(cc.hora_registro,'%H:%i:%s')) AS fecha
                    FROM control_camara_archivo ca
                    LEFT JOIN control_camara cc ON ca.id_control_camara=cc.id
                    LEFT JOIN local lo ON cc.id_tienda=lo.id_local
                    LEFT JOIN control_camara_ronda cr ON ca.id_ronda=cr.id
                    WHERE $parte_sede $parte_local cc.estado=1
                    ORDER BY cc.fecha DESC,cc.hora_registro DESC";
            $query = DB::select($sql);
            return $query;
        }
    }
}
