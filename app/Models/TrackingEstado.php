<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrackingEstado extends Model
{
    use HasFactory;

    protected $table = 'tracking_estado';

    public $timestamps = false;

    protected $fillable = [
        'id_proceso',
        'descripcion'
    ];

    static function get_list_estado_proceso() {
        $query = "select *, CONCAT(CASE WHEN DAYNAME(tdp.fec_reg)='Monday' THEN 'Lun'
                    WHEN DAYNAME(tdp.fec_reg)='Tuesday' THEN 'Mar'
                    WHEN DAYNAME(tdp.fec_reg)='Wednesday' THEN 'Mie'
                    WHEN DAYNAME(tdp.fec_reg)='Thursday' THEN 'Jue'
                    WHEN DAYNAME(tdp.fec_reg)='Friday' THEN 'Vie'
                    WHEN DAYNAME(tdp.fec_reg)='Saturday' THEN 'Sab'
                    WHEN DAYNAME(tdp.fec_reg)='Sunday' THEN 'Dom' ELSE '' END,' ',
                    DATE_FORMAT(tdp.fec_reg,'%d/%m/%Y')) AS fecha,
                    DATE_FORMAT(tdp.fec_reg,'%H:%i:%s') AS hora
                    from tracking_detalle_proceso tdp
                    left join tracking_estado te ON te.id_proceso=tdp.id_proceso;";
        
        $result = DB::select($query);
        return json_decode(json_encode($result), true);
    }
}
