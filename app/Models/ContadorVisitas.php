<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContadorVisitas extends Model
{
    use HasFactory;

    // Define la tabla si no sigue la convención plural de Laravel
    protected $table = 'contador_visitas';

    // Define la clave primaria
    protected $primaryKey = 'id_contador_visitas';

    // Si la tabla tiene timestamps automáticos
    public $timestamps = false;

    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'cod_tienda',
        'fecha',
        'hora',
        'entradas',
        'salidas',
        'anio',
        'mes',
        'dia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    static function get_list_contador_vistas($dato){
        $base="";
        if($dato['id_base']!=0){
            if(count($dato['get_asociacion'])>0){
                $base=" and cod_tienda='".$dato['get_asociacion'][0]['cod_tienda']."' ";
            }else{
                $base=" and cod_tienda='".$dato['id_base']."' ";
            }
        }
        $sql="SELECT * from contador_visitas where estado=1 $base and fecha between '".$dato['inicio']."' and '".$dato['fin']."'";

        $query = DB::connection('sqlsrv_dbmsrt')->select($sql);
        return json_decode(json_encode($query), true);
    }
}
