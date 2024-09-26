<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChequesLetras extends Model
{
    use HasFactory;

    protected $table = 'cheques_letras';
    protected $primaryKey = 'id_cheque_letra';

    public $timestamps = false;

    protected $fillable = [
        'cod_registro',
        'fec_emision',
        'fec_vencimiento',
        'id_tipo_documento',
        'num_doc',
        'tipo_doc_aceptante',
        'num_doc_aceptante',
        'tipo_doc_emp_vinculada',
        'num_doc_emp_vinculada',
        'id_tipo_comprobante',
        'num_comprobante',
        'id_moneda',
        'monto',
        'negociado_endosado',
        'id_empresa',
        'fec_pago',
        'noperacion',
        'tipo_nunico',
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

    public static function get_list_cheques_letra($dato)
    {
        $parte_estado = "";
        if($dato['estado']!="0"){
            $parte_estado = "cl.estado_registro='".$dato['estado']."' AND";
        }
        $parte_empresa = "";
        if($dato['id_empresa']!="0"){
            $parte_empresa = "cl.id_empresa='".$dato['id_empresa']."' AND";
        }
        $parte_aceptante = "";
        if($dato['id_aceptante']!="0"){
            $aceptante = explode("_",$dato['id_aceptante']);
            $tipo_doc_aceptante = $aceptante[0];
            $num_doc_aceptante = $aceptante[1];
            $parte_aceptante = "cl.tipo_doc_aceptante='$tipo_doc_aceptante' AND cl.num_doc_aceptante='$num_doc_aceptante' AND";
        }
        $parte_mes = "";
        if($dato['mes']!="0"){
            if($dato['tipo_fecha']==1){
                $parte_mes = "MONTH(cl.fec_emision)='".$dato['mes']."' AND";
            }else{
                $parte_mes = "MONTH(cl.fec_vencimiento)='".$dato['mes']."' AND";
            }
        }
        $parte_anio = "";
        if($dato['anio']!="0"){
            if($dato['tipo_fecha']==1){
                $parte_anio = "YEAR(cl.fec_emision)='".$dato['anio']."' AND";
            }else{
                $parte_anio = "YEAR(cl.fec_vencimiento)='".$dato['anio']."' AND";
            }
        }

        $sql = "SELECT cl.id_cheque_letra,em.nom_empresa,
                DATE_FORMAT(cl.fec_emision,'%d-%m-%Y') AS fec_emision,
                DATE_FORMAT(cl.fec_vencimiento,'%d-%m-%Y') AS fec_vencimiento,
                CASE WHEN cl.fec_pago IS NOT NULL THEN DATE_FORMAT(cl.fec_pago,'%d-%m-%Y') 
                ELSE '' END AS fec_pago,
                CASE WHEN cl.estado_registro=1 THEN DATEDIFF(CURDATE(), cl.fec_vencimiento)
                WHEN cl.estado_registro=2 THEN DATEDIFF(cl.fec_pago, cl.fec_vencimiento)
                ELSE NULL END AS dias_atraso,
                CASE WHEN cl.id_tipo_documento=1 THEN 'Cheque' 
                WHEN cl.id_tipo_documento=2 THEN 'Letra' END AS nom_tipo_documento,cl.num_doc,
                CONCAT(cl.tipo_doc_aceptante,'_',cl.num_doc_aceptante) AS id_aceptante,
                tc.nom_tipo_comprobante,cl.num_comprobante,CONCAT(tm.cod_moneda,' ',cl.monto) AS total,
                CASE WHEN cl.negociado_endosado=1 THEN 'Negociado' 
                WHEN cl.negociado_endosado=2 THEN 'Endosado' ELSE '' END AS negociado_endosado,
                CONCAT(cl.tipo_doc_emp_vinculada,'_',cl.num_doc_emp_vinculada) AS id_empresa_vinculada,
                CASE WHEN cl.tipo_nunico=1 AND cl.num_unico<>'' THEN CONCAT(cl.num_unico,' ','(NU)')
                WHEN cl.tipo_nunico=2 AND cl.num_cuenta<>'' THEN CONCAT(cl.num_cuenta,' ','(Cta)') 
                ELSE '' END AS num_unico,
                CASE WHEN cl.estado_registro=1 THEN 'Por Cancelar' 
                WHEN cl.estado_registro=2 THEN 'Cancelado' ELSE '' END AS nom_estado,cl.estado_registro,
                cl.documento,cl.banco,cl.comprobante_pago,cl.id_moneda,cl.monto,cl.noperacion
                FROM cheques_letras cl
                INNER JOIN empresas em ON em.id_empresa=cl.id_empresa
                INNER JOIN vw_tipo_comprobante tc ON tc.id=cl.id_tipo_comprobante
                INNER JOIN tipo_moneda tm ON tm.id_moneda=cl.id_moneda
                WHERE $parte_anio $parte_mes $parte_empresa $parte_aceptante $parte_estado cl.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
