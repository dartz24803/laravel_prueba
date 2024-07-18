<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReporteFotografico extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reporte_fotografico_new';

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

    public function listar($base, $categoria, $fecha){

        if($base==0){
            $parte1 = "";
        }else{
            $parte1 = " AND rf.base = '$base'";
        }

        if($categoria==0){
            $parte2 = "";
        }else{
            $parte2 = " AND crf.tipo = '$categoria'";
        }
        
        if($fecha==''){
            $parte3 = "";
        }else{
            $parte3 = " AND DATE(rf.fec_reg) = '$fecha'";
        }
        //borrar codigo=10
        $query = "select rf.id,rf.base,rf.foto,crf.descripcion,rfa.categoria,rf.fec_reg, GROUP_CONCAT(a.nom_area ORDER BY rfd.id DESC SEPARATOR ', ') as areas from reporte_fotografico_new rf
            left join codigos_reporte_fotografico_new crf ON rf.codigo = crf.id
            left join reporte_fotografico_adm_new rfa ON crf.tipo = rfa.id
            LEFT JOIN reporte_fotografico_detalle_new rfd ON rfa.id = rfd.id_reporte_fotografico_adm
            LEFT JOIN area a ON rfd.id_area = a.id_area
            where rf.estado=1 $parte1 $parte2 $parte3
            GROUP BY rf.id,rf.base,rf.foto,crf.descripcion,rfa.categoria,rf.fec_reg ORDER BY fec_reg DESC;";

        $result = DB::select($query);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    public function listar_imagenes($base, $categoria){
        if($base==0){
            $parte1 = "";
        }else{
            $parte1 = " AND rf.base = '$base'";
        }

        if($categoria==0){
            $parte2 = "";
        }else{
            $parte2 = " AND crf.tipo = '$categoria'";
        }

        $query = "select rf.*,crf.descripcion,crf.tipo from reporte_fotografico rf
        left join codigos_reporte_fotografico crf ON rf.codigo = crf.descripcion
        where rf.estado=1 $parte1 $parte2 ORDER BY rf.fec_reg DESC;";

        $result = DB::select($query);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

}
