<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FinanzasCheque extends Model
{
    use HasFactory;

    protected $table = 'finanzas_cheque';
    protected $primaryKey = 'id_cheque';

    public $timestamps = false;

    protected $fillable = [
        'cod_cheque',
        'id_empresa',
        'id_banco',
        'n_cheque',
        'id_tipo',
        'fec_emision',
        'fec_vencimiento',
        'id_proveedor',
        'tipo_doc',
        'num_doc',
        'razon_social',
        'concepto',
        'id_moneda',
        'importe',
        'estado_cheque',
        'fec_autorizado',
        'fec_pend_cobro',
        'fec_cobro',
        'noperacion',
        'motivo_anulado',
        'img_cheque',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    public static function get_list_cheque($dato=null){
        $parte_empresa = "";
        if($dato['todos']=="1"){
            $parte_empresa = "";
        }elseif(isset($dato['id_empresa']) && count($dato['id_empresa'])>0){
            $parte_empresa = "fc.id_empresa IN ('".implode("','",$dato['id_empresa'])."') AND";
        }

        $parte_estado = "";
        if($dato['estado']!="0"){
            $parte_estado = "fc.estado_cheque=".$dato['estado']." AND";
        }

        if($dato['tipo_fecha']=="1"){
            $parte_fecha = "(fc.fec_emision BETWEEN '".$dato['fec_inicio']."' AND '".$dato['fec_fin']."') AND";
        }else{
            $parte_fecha = "(fc.fec_vencimiento BETWEEN '".$dato['fec_inicio']."' AND '".$dato['fec_fin']."') AND";
        }

        $sql = "SELECT fc.id_cheque,em.nom_empresa,ba.nom_banco,fc.n_cheque,
                DATE_FORMAT(fc.fec_emision,'%d-%m-%Y') AS fec_emision,
                DATE_FORMAT(fc.fec_vencimiento,'%d-%m-%Y') AS fec_vencimiento,
                CONCAT(fc.tipo_doc,'_',fc.num_doc) AS id_girado,
                cc.nom_concepto_cheque,CONCAT(tm.cod_moneda,' ',fc.importe) AS total,fc.estado_cheque,
                fc.motivo_anulado, CASE WHEN fc.fec_cobro IS NOT NULL OR fc.fec_cobro NOT LIKE '%000%' THEN 
                DATE_FORMAT(fc.fec_cobro,'%d-%m-%Y') ELSE '' END AS fec_cobro,fc.noperacion,
                CASE WHEN fc.estado_cheque=1 THEN 'Pendiente de Autorización'
                WHEN fc.estado_cheque=2 THEN 'Autorizado'
                WHEN fc.estado_cheque=3 THEN 'Pendiente de Cancelación'
                WHEN fc.estado_cheque=4 THEN 'Cancelado'
                WHEN fc.estado_cheque=5 THEN 'Anulación Pendiente'
                WHEN fc.estado_cheque=6 THEN 'Anulado' END AS nom_estado,fc.id_moneda,fc.importe
                FROM finanzas_cheque fc 
                INNER JOIN empresas em on fc.id_empresa=em.id_empresa
                INNER JOIN banco ba on fc.id_banco=ba.id_banco
                INNER JOIN tipo_moneda tm on fc.id_moneda=tm.id_moneda
                LEFT JOIN concepto_cheque cc on fc.concepto=cc.id_concepto_cheque
                WHERE $parte_fecha $parte_empresa $parte_estado fc.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
