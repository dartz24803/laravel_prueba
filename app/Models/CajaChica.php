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
        'tipo_movimiento',
        'id_ubicacion',
        'id_categoria',
        'fecha',
        'id_sub_categoria',
        'id_empresa',
        'id_usuario',
        'descripcion',
        'id_tipo_moneda',
        'ruc',
        'razon_social',
        'id_tipo_comprobante',
        'n_comprobante',
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
        if(isset($dato['id'])){
            $sql = "SELECT cc.*,IFNULL((SELECT SUM(cr.costo) FROM caja_chica_ruta cr
                    WHERE cr.id_caja_chica=cc.id),0) AS total,ca.nom_categoria,sc.nombre,
                    CASE WHEN cc.id_tipo_comprobante=6 THEN 'TICKET' ELSE tc.nom_tipo_comprobante 
                    END AS nom_tipo_comprobante,ub.cod_ubi,em.nom_empresa,pa.nom_pago,
                    tp.nombre AS nom_tipo_pago,
                    CONCAT(tm.cod_moneda,' ',IFNULL((SELECT SUM(cr.costo) FROM caja_chica_ruta cr
                    WHERE cr.id_caja_chica=cc.id),0)) AS total_concatenado
                    FROM caja_chica cc
                    INNER JOIN categoria ca ON ca.id_categoria=cc.id_categoria
                    INNER JOIN sub_categoria sc ON sc.id=cc.id_sub_categoria
                    INNER JOIN vw_tipo_comprobante tc ON tc.id=cc.id_tipo_comprobante
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=cc.id_ubicacion
                    INNER JOIN empresas em ON em.id_empresa=cc.id_empresa
                    LEFT JOIN vw_pago pa ON pa.id_pago=cc.id_pago
                    LEFT JOIN tipo_pago tp ON tp.id=cc.id_tipo_pago
                    INNER JOIN tipo_moneda tm ON tm.id_moneda=cc.id_tipo_moneda
                    WHERE cc.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $sql = "SELECT cc.id,cc.fecha AS orden,
                    DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,ub.cod_ubi,
                    ca.nom_categoria,sc.nombre,em.nom_empresa,CASE WHEN cc.tipo_movimiento=1 THEN 'Ingreso'
                    WHEN cc.tipo_movimiento=2 THEN 'Salida' ELSE '' END AS movimiento,
                    CASE WHEN cc.id_tipo_comprobante=6 THEN 'TICKET' ELSE tc.nom_tipo_comprobante 
                    END AS nom_tipo_comprobante,cc.n_comprobante,
                    CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',us.usuario_apater) AS nom_solicitante,
                    cc.ruc,cc.razon_social,cc.descripcion,CONCAT(tm.cod_moneda,' ',
                    CASE WHEN ca.nom_categoria='MOVILIDAD' THEN 
                    IFNULL((SELECT SUM(cr.costo) FROM caja_chica_ruta cr
                    WHERE cr.id_caja_chica=cc.id),0) ELSE 0 END) AS total,
                    CASE WHEN cc.estado_c=1 THEN 'Por revisar'
                    WHEN cc.estado_c=2 THEN 'Completado' WHEN cc.estado_c=3 THEN 'Anulado' 
                    ELSE '' END AS nom_estado,
                    CASE WHEN cc.estado_c=1 THEN '#9DA7B9'
                    WHEN cc.estado_c=2 THEN '#028B35' WHEN cc.estado_c=3 THEN '#FF3131' 
                    ELSE 'transparent' END AS color_estado,cc.comprobante,cc.estado_c
                    FROM caja_chica cc
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=cc.id_ubicacion
                    INNER JOIN categoria ca ON ca.id_categoria=cc.id_categoria
                    INNER JOIN sub_categoria sc ON sc.id=cc.id_sub_categoria
                    INNER JOIN empresas em ON em.id_empresa=cc.id_empresa
                    INNER JOIN vw_tipo_comprobante tc ON tc.id=cc.id_tipo_comprobante
                    INNER JOIN users us ON us.id_usuario=cc.id_usuario
                    INNER JOIN tipo_moneda tm ON tm.id_moneda=cc.id_tipo_moneda
                    WHERE cc.estado=1";
            $query = DB::select($sql);
            return $query;
        }
    }
}
