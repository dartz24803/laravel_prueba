<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GastoServicio extends Model
{
    use HasFactory;

    protected $table = 'gasto_servicio';
    protected $primaryKey = 'id_gasto_servicio';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'id_servicio',
        'id_lugar_servicio',
        'id_proveedor_servicio',
        'suministro',
        'mes',
        'anio',
        'documento_serie',
        'documento_numero',
        'lant_dato',
        'lant_fecha',
        'lact_dato',
        'lact_fecha',
        'fec_emision',
        'fec_vencimiento',
        'importe',
        'documento',
        'fec_pago',
        'user_pago',
        'comprobante',
        'comision',
        'num_operacion',
        'autogenerado',
        'estado_servicio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_registro_servicio($dato=null){
        $parte_mes = "";
        if($dato['mes']!=""){
            $parte_mes = "AND gs.mes='".$dato['mes']."'";
        }

        $parte_base = "";
        if($dato['todos']=="1"){
            $parte_base = "";
        }elseif(isset($dato['cod_base']) && count($dato['cod_base'])>0){
            $parte_base = "AND gs.cod_base IN ('".implode("','",$dato['cod_base'])."') ";
        }

        $parte_estado = "";
        if($dato['estado']!="0"){
            $parte_estado = "AND gs.estado_servicio='".$dato['estado']."'";
        }

        $parte_servicio = "";
        if($dato['id_servicio']!="0"){
            $parte_servicio = "AND gs.id_servicio='".$dato['id_servicio']."'";
        }

        $parte_lugar = "";
        if($dato['id_lugar_servicio']!="0"){
            $parte_lugar = "AND gs.id_lugar_servicio='".$dato['id_lugar_servicio']."'";
        }
        
        $sql = "SELECT gs.id_gasto_servicio,gs.cod_base,se.nom_servicio,ls.nom_lugar_servicio,
                CASE WHEN gs.importe>0 THEN CONCAT('S/ ',gs.importe) ELSE '' END AS importe,
                CONCAT(me.nom_mes,'-',gs.anio) AS periodo,
                CASE WHEN gs.estado_servicio=1 THEN 'Por Cancelar' 
                WHEN gs.estado_servicio=2 THEN 'Cancelado' ELSE '' END AS nom_estado,se.lectura,
                /*PROGRESO*/
                (CASE WHEN gs.id_lugar_servicio!=0 THEN 1 ELSE 0 END) AS lugar_servicio,
                (CASE WHEN gs.id_servicio!=0 THEN 1 ELSE 0 END) AS servicio,
                (CASE WHEN gs.id_proveedor_servicio!=0 THEN 1 ELSE 0 END) AS proveedor_servicio,
                (CASE WHEN gs.suministro!=0 THEN 1 ELSE 0 END) AS suministro,
                (CASE WHEN gs.documento_serie IS NOT NULL THEN 1 ELSE 0 END) AS documentoserie,
                (CASE WHEN gs.documento_numero IS NOT NULL THEN 1 ELSE 0 END) AS documentonumero,
                (CASE WHEN gs.fec_vencimiento IS NOT NULL THEN 1 ELSE 0 END) AS fecha_vencimiento,
                (CASE WHEN gs.importe IS NOT NULL THEN 1 ELSE 0 END) AS importe_porc,
                (CASE WHEN gs.documento IS NOT NULL THEN 1 ELSE 0 END) AS documento_porc,
                (CASE WHEN gs.lant_dato IS NOT NULL THEN 1 ELSE 0 END) AS lantdato,
                (CASE WHEN gs.lant_fecha IS NOT NULL THEN 1 ELSE 0 END) AS lantfecha,
                (CASE WHEN gs.lact_dato IS NOT NULL THEN 1 ELSE 0 END) AS lactdato,
                (CASE WHEN gs.lact_fecha IS NOT NULL THEN 1 ELSE 0 END) AS lactfecha,
                /**/
                gs.estado_servicio,CASE WHEN SUBSTRING(gs.comprobante,1,5)='https' 
                THEN gs.comprobante ELSE CONCAT('https://grupolanumero1.com.pe/intranet/',gs.comprobante) 
                END AS comprobante,gs.documento,gs.importe AS total,gs.fec_pago,gs.num_operacion,gs.lant_dato,
                CASE WHEN gs.lant_fecha IS NOT NULL AND gs.lant_fecha NOT LIKE '%0000%' THEN gs.lant_fecha 
                ELSE '' END AS lant_fecha,gs.lact_dato,
                CASE WHEN gs.lact_fecha IS NOT NULL AND gs.lact_fecha NOT LIKE '%0000%' THEN gs.lact_fecha 
                ELSE '' END AS lact_fecha
                FROM gasto_servicio gs
                INNER JOIN servicio se ON gs.id_servicio=se.id_servicio
                INNER JOIN vw_lugar_servicio ls ON gs.id_lugar_servicio=ls.id_lugar_servicio
                INNER JOIN mes me ON gs.mes=me.id_mes
                WHERE gs.anio='".$dato['anio']."' $parte_mes $parte_base $parte_estado $parte_servicio 
                $parte_lugar AND gs.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
