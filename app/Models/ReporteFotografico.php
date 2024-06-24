<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReporteFotografico extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reporte_fotografico';

    protected $fillable = [
        'id',
        'base',
        'foto',
        'codigo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    /*
    public function buscar($id)
    {
        return $this->where('id', $id)->get()->toArray();
    }*/

    public function listar($base, $area, $codigo)
    {

        if($base==0){
            $parte1 = "";
        }else{
            $parte1 = " AND rf.base = '$base'";
        }
        if($area==0){
            $parte2 = "";
        }else{
            $parte2 = " AND EXISTS (SELECT 1
                                   FROM reporte_fotografico_adm rfa
                                   WHERE rfa.tipo = crf.tipo
                                   AND rfa.area = $area)";
        }
        if($codigo==0){
            $parte3 = "";
        }else{
            $parte3 = " AND rf.codigo = '$codigo'";
        }

        $query = "SELECT rf.*,crf.tipo,
                COALESCE(
                    (SELECT GROUP_CONCAT(DISTINCT a.nom_area SEPARATOR ', ')
                    FROM reporte_fotografico_adm rfa
                    LEFT JOIN area a ON rfa.area = a.id_area
                    WHERE rfa.tipo COLLATE utf8mb4_general_ci = crf.tipo COLLATE utf8mb4_general_ci),
                    NULL
                ) AS areas
            FROM reporte_fotografico rf
            LEFT JOIN codigos_reporte_fotografico crf ON rf.codigo COLLATE utf8mb4_general_ci = crf.descripcion COLLATE utf8mb4_general_ci
            WHERE rf.estado = 1 $parte1 $parte2 $parte3 ORDER BY rf.fec_reg ASC;";

        $result = DB::select($query);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

}
