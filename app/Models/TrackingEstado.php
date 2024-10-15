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
        $query = "select tdp.id, tdp.id_tracking, te.descripcion, te.id_proceso,
                CONCAT(CASE WHEN DAYNAME(tde.fec_reg)='Monday' THEN 'Lun'
                                    WHEN DAYNAME(tde.fec_reg)='Tuesday' THEN 'Mar'
                                    WHEN DAYNAME(tde.fec_reg)='Wednesday' THEN 'Mie'
                                    WHEN DAYNAME(tde.fec_reg)='Thursday' THEN 'Jue'
                                    WHEN DAYNAME(tde.fec_reg)='Friday' THEN 'Vie'
                                    WHEN DAYNAME(tde.fec_reg)='Saturday' THEN 'Sab'
                                    WHEN DAYNAME(tde.fec_reg)='Sunday' THEN 'Dom' ELSE '' END,' ',
                                    DATE_FORMAT(tde.fec_reg,'%d/%m/%Y')) AS fecha,
                                    DATE_FORMAT(tde.fec_reg,'%H:%i:%s') AS hora
                from tracking_detalle_estado tde
                left join tracking_detalle_proceso tdp ON tde.id_detalle=tdp.id
                left join tracking_estado te ON tde.id_estado=te.id;";
        
        $result = DB::select($query);
        return json_decode(json_encode($result), true);
    }
}
