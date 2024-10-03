<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LetrasCobrar extends Model
{
    use HasFactory;

    protected $table = 'letras_cobrar';
    protected $primaryKey = 'id_letra_cobrar';

    public $timestamps = false;

    protected $fillable = [
        'cod_registro',
        'fec_emision',
        'fec_vencimiento',
        'id_tipo_documento',
        'num_doc',
        'tipo_doc_cliente',
        'num_doc_cliente',
        'id_tipo_comprobante',
        'num_comprobante',
        'id_moneda',
        'monto',
        'id_empresa',
        'fec_pago',
        'noperacion',
        'num_unico',
        'num_cuenta',
        'banco',
        'documento',
        'comprobante_pago',
        'estado_registro',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_letra_cobrar($dato)
    {
        $parte_estado = "";
        if($dato['estado']!="0"){
            $parte_estado = "lc.estado_registro='".$dato['estado']."' AND";
        }
        $parte_empresa = "";
        if($dato['id_empresa']!="0"){
            $parte_empresa = "lc.id_empresa='".$dato['id_empresa']."' AND";
        }
        $parte_cliente = "";
        if($dato['id_cliente']!="0"){
            $cliente = explode("_",$dato['id_cliente']);
            $tipo_doc_cliente = $cliente[0];
            $num_doc_cliente = $cliente[1];
            $parte_cliente = "lc.tipo_doc_cliente='$tipo_doc_cliente' AND lc.num_doc_cliente='$num_doc_cliente' AND";
        }
        $parte_mes = "";
        if($dato['mes']!="0"){
            $parte_mes = "MONTH(lc.fec_emision)='".$dato['mes']."' AND";
        }
        $parte_anio = "";
        if($dato['anio']!="0"){
            $parte_anio = "YEAR(lc.fec_emision)='".$dato['anio']."' AND";
        }

        $sql = "SELECT lc.id_letra_cobrar,em.nom_empresa,
                DATE_FORMAT(lc.fec_emision,'%d-%m-%Y') AS fec_emision,
                DATE_FORMAT(lc.fec_vencimiento,'%d-%m-%Y') AS fec_vencimiento,
                CASE WHEN lc.estado_registro=1 THEN DATEDIFF(CURDATE(), lc.fec_vencimiento)
                WHEN lc.estado_registro=2 THEN DATEDIFF(lc.fec_pago, lc.fec_vencimiento)
                ELSE NULL END AS dias_atraso,
                CASE WHEN lc.id_tipo_documento=1 THEN 'Cheque' 
                WHEN lc.id_tipo_documento=2 THEN 'Letra' END AS nom_tipo_documento,lc.num_doc,
                CONCAT(lc.tipo_doc_cliente,'_',lc.num_doc_cliente) AS id_cliente,
                tc.nom_tipo_comprobante,lc.num_comprobante,CONCAT(tm.cod_moneda,' ',lc.monto) AS total,
                lc.num_unico,CASE WHEN lc.estado_registro=1 THEN 'Por Cancelar' 
                WHEN lc.estado_registro=2 THEN 'Cancelado' ELSE '' END AS nom_estado,lc.estado_registro,
                lc.documento,lc.banco,lc.comprobante_pago,lc.id_moneda,lc.monto,lc.noperacion,
                CASE WHEN lc.fec_pago IS NOT NULL THEN DATE_FORMAT(lc.fec_pago,'%d-%m-%Y') 
                ELSE '' END AS fec_pago
                FROM letras_cobrar lc
                INNER JOIN empresas em ON em.id_empresa=lc.id_empresa
                INNER JOIN vw_tipo_comprobante tc ON tc.id=lc.id_tipo_comprobante
                INNER JOIN tipo_moneda tm ON tm.id_moneda=lc.id_moneda
                WHERE $parte_anio $parte_mes $parte_empresa $parte_cliente $parte_estado lc.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
