<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArchivosAperturaCierreTienda extends Model
{
    use HasFactory;

    protected $table = 'archivos_apertura_cierre_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_apertura_cierre',
        'tipo_apertura',
        'archivo',
        'fecha',
        'usuario'
    ];

    public static function get_list_archivos_apertura_cierre_tienda($dato)
    {
        $parte = "";
        if($dato['cod_base']!="0"){
            $parte = "AND ac.cod_base='".$dato['cod_base']."'";
        }
        $sql = "SELECT aa.id,aa.archivo,CASE WHEN aa.tipo_apertura=1 THEN 'Ingreso de personal' 
                WHEN aa.tipo_apertura=2 THEN 'Apertura de tienda'
                WHEN aa.tipo_apertura=3 THEN 'Cierre de tienda'
                WHEN aa.tipo_apertura=4 THEN 'Salida de personal' ELSE '' END AS tipo_apertura,
                DATE_FORMAT(aa.fecha,'%d/%m/%Y %H:%i:%s') AS fecha
                FROM archivos_apertura_cierre_tienda aa
                INNER JOIN apertura_cierre_tienda ac ON aa.id_apertura_cierre=ac.id_apertura_cierre
                WHERE (ac.fecha BETWEEN '".$dato['fec_ini']."' AND '".$dato['fec_fin']."') $parte AND 
                ac.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
