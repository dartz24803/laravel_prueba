<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequerimientoTemporal extends Model
{
    protected $table = 'requerimiento_temporal';
    protected $primaryKey = 'id_temporal';
    public $timestamps = false;

    protected $fillable = [
        'empresa',
        'costo',
        'pc',
        'pv',
        'pp',
        'pc_b4',
        'pv_b4',
        'pp_b4',
        'tipo_usuario',
        'tipo_prenda',
        'codigo',
        'autogenerado',
        'estilo',
        'descripcion',
        'color',
        'talla',
        'total',
        'OBS',
        'stock',
        'B01',
        'B02',
        'B03',
        'B04',
        'B05',
        'B06',
        'B07',
        'B08',
        'B09',
        'B10',
        'B11',
        'B12',
        'B13',
        'B14',
        'B15',
        'B16',
        'B17',
        'B18',
        'BEC',
        'REQ',
        'OFC',
        'mes',
        'anio',
        'caracter',
        'duplicado',
        'ubicacion',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    static function get_list_requerimiento_duplicado_temporal(){
        $id_usuario = session('id_usuario')->id_usuario;
        $sql = "SELECT t.*,
        case when t.duplicado=1 then concat(' ','Duplicado:',' ',t.caracter)
        when t.caracter!='' then t.caracter end as observacion
        FROM requerimiento_temporal t where (t.user_reg='$id_usuario' and t.estado=1 and t.duplicado=1) or (t.user_reg='$id_usuario' and t.estado=1 and t.caracter!='')";

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
