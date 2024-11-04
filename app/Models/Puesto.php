<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puesto';
    protected $primaryKey = 'id_puesto';

    public $timestamps = false;

    protected $fillable = [
        'id_area',
        'nom_puesto',
        'proposito',
        'id_nivel',
        'id_sede_laboral',
        'perfil_infosap',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function get_list_puesto_horario($base){
        $sql = "SELECT us.id_puesto,pu.nom_puesto
                FROM users us
                LEFT JOIN puesto pu ON us.id_puesto=pu.id_puesto
                WHERE us.centro_labores='$base' AND us.estado=1 AND pu.nom_puesto NOT LIKE 'BASE%'
                GROUP BY us.id_puesto,pu.nom_puesto
                ORDER BY pu.nom_puesto ASC";

        $result = DB::select($sql);

        return json_decode(json_encode($result), true);
    }

    public static function get_list_puesto_ft()
    {
        $sql = "SELECT id_puesto,nom_puesto 
                FROM puesto 
                WHERE (id_area=14 OR id_puesto=36) AND estado=1
                ORDER BY nom_puesto ASC";
        $query = DB::select($sql);
        return $query;
    }
    
    public function list_puestos_jefes(){
                
        $sql = "SELECT GROUP_CONCAT(puestos) as puestos FROM area WHERE estado=1 AND orden IS NOT NULL and puestos <>''";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
    
    static function get_list_puesto($id_gerencia=null, $id_area=null){
        if(isset($id_gerencia) && $id_gerencia > 0 && isset($id_area) && $id_area > 0){
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area,d.direccion,n.nom_nivel FROM puesto t
                    LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                    LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                    left join direccion d on t.id_direccion=d.id_direccion
                    left join nivel_jerarquico n on t.id_nivel=n.id_nivel
                    WHERE t.estado='1' and t.id_gerencia=$id_gerencia and t.id_area=$id_area";
        }elseif(isset($id_gerencia) && $id_gerencia > 0 && $id_area==null){
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area,d.direccion,n.nom_nivel FROM puesto t
                LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                left join direccion d on t.id_direccion=d.id_direccion
                left join nivel_jerarquico n on t.id_nivel=n.id_nivel
                WHERE t.estado='1' and t.id_gerencia=$id_gerencia";
        }else{
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area,d.direccion,n.nom_nivel FROM puesto t
                LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                left join direccion d on t.id_direccion=d.id_direccion
                left join nivel_jerarquico n on t.id_nivel=n.id_nivel
                WHERE t.estado='1'";
        }
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}