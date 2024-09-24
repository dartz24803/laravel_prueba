<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CajaChica extends Model
{
    use HasFactory;

    protected $table = 'caja_chica';

    public $timestamps = false;

    protected $fillable = [
        'id_ubicacion',
        'id_categoria',
        'fecha',
        'id_sub_categoria',
        'id_empresa',
        'id_tipo_moneda',
        'total',
        'ruc',
        'razon_social',
        'ruta',
        'id_tipo_comprobante',
        'n_comprobante',
        'punto_partida',
        'punto_llegada',
        'comprobante',
        'id_pago',
        'id_tipo_pago',
        'cuenta_1',
        'cuenta_2',
        'fecha_pago',
        'estado_c',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_caja_chica($dato=null){
        $sql = "SELECT cc.id,cc.fecha AS orden,
                DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,ub.cod_ubi,
                ca.nom_categoria,sc.nombre,em.nom_empresa,
                CASE WHEN ca.nom_categoria='MOVILIDAD' THEN 
                (CASE WHEN cc.ruta=1 THEN CONCAT(cc.punto_partida,' - ',cc.punto_llegada) 
                ELSE cc.punto_llegada END) ELSE cc.punto_partida END AS descripcion,
                cc.ruc,cc.razon_social,tc.nom_tipo_comprobante,cc.n_comprobante,
                CONCAT(tm.cod_moneda,' ',cc.total) AS total,cc.comprobante,
                CASE WHEN cc.estado_c=1 THEN 'Por revisar'
                WHEN cc.estado_c=2 THEN 'Completado' ELSE '' END AS nom_estado,
                cc.estado_c 
                FROM caja_chica cc
                INNER JOIN ubicacion ub ON ub.id_ubicacion=cc.id_ubicacion
                INNER JOIN categoria ca ON ca.id_categoria=cc.id_categoria
                INNER JOIN sub_categoria sc ON sc.id=cc.id_sub_categoria
                INNER JOIN empresas em ON em.id_empresa=cc.id_empresa
                INNER JOIN vw_tipo_comprobante tc ON tc.id=cc.id_tipo_comprobante
                INNER JOIN tipo_moneda tm ON tm.id_moneda=cc.id_tipo_moneda
                WHERE cc.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
