<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CajaChicaPago extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_pago';

    public $timestamps = false;

    protected $fillable = [
        'id_caja_chica',
        'fecha',
        'monto'
    ];
    
    public static function get_list_tabla_maestra($dato=null){
        $sql = "SELECT cp.fecha AS orden,
                DATE_FORMAT(cp.fecha,'%d-%m-%Y') AS fecha,
                pa.nom_pago,tp.nombre AS nom_tipo_pago,'' AS cuenta_1,'' AS cuenta_2,ub.cod_ubi,
                'Caja chica' AS nom_macro_categoria,ca.nom_categoria,sc.nombre AS nom_sub_categoria,
                em.nom_empresa,cc.razon_social,tc.nom_tipo_comprobante,cc.n_comprobante,
                CONCAT(tm.cod_moneda,' ',cp.monto) AS total,
                CASE WHEN ca.nom_categoria='MOVILIDAD' THEN 
                (CASE WHEN cc.ruta=1 THEN CONCAT(cc.punto_partida,' - ',cc.punto_llegada) 
                ELSE cc.punto_llegada END) ELSE cc.punto_partida END AS descripcion,
                cc.comprobante
                FROM caja_chica_pago cp
                INNER JOIN caja_chica cc ON cc.id=cp.id_caja_chica
                LEFT JOIN vw_pago pa ON pa.id_pago=cc.id_pago
                LEFT JOIN tipo_pago tp ON tp.id=cc.id_tipo_pago
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
