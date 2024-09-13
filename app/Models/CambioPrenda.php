<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CambioPrenda extends Model
{
    use HasFactory;

    protected $table = 'cambio_prenda';
    protected $primaryKey = 'id_cambio_prenda';

    public $timestamps = false;

    protected $fillable = [
        'tipo_boleta',
        'cod_cambio',
        'base',
        'tipo_comprobante',
        'serie',
        'n_documento',
        'nuevo_num_comprobante',
        'nuevo_num_serie',
        'id_motivo',
        'otro',
        'nom_cliente',
        'telefono',
        'vendedor',
        'num_caja',
        'fecha',
        'hora',
        'estado_cambio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_cambio_prenda($dato){
        if(isset($dato['id_cambio_prenda'])){
            $sql = "SELECT cp.*,CASE WHEN cp.tipo_boleta='2' THEN 
                    (SELECT cd.n_codi_arti FROM cambio_prenda_detalle cd 
                    WHERE cd.id_cambio_prenda=cp.id_cambio_prenda
                    LIMIT 1) ELSE '' END AS n_codi_arti,
                    CASE WHEN cp.tipo_boleta='2' THEN 
                    (SELECT cd.n_cant_vent FROM cambio_prenda_detalle cd 
                    WHERE cd.id_cambio_prenda=cp.id_cambio_prenda
                    LIMIT 1) ELSE '' END AS n_cant_vent
                    FROM cambio_prenda cp 
                    WHERE cp.id_cambio_prenda=".$dato['id_cambio_prenda'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $parte_base = "";
            $parte_estado = "";
            if(session('usuario')->id_nivel=="1" || 
            session('usuario')->id_puesto=="128"){
                $parte_base = "";
                $parte_estado = "";
            }
            if(session('usuario')->id_puesto=="29" || 
            session('usuario')->id_puesto=="31" || 
            session('usuario')->id_puesto=="36" || 
            session('usuario')->id_puesto=="23" || 
            session('usuario')->id_puesto=="98" ||
            session('usuario')->id_puesto=="20" || 
            session('usuario')->id_puesto=="26" || 
            session('usuario')->id_puesto=="27" || 
            session('usuario')->id_puesto=="148" || 
            session('usuario')->id_puesto=="16" || 
            session('usuario')->id_puesto=="30" || 
            session('usuario')->id_puesto=="161" || 
            session('usuario')->id_puesto=="197"){ 
                $parte_base = "AND cp.base='".session('usuario')->centro_labores."'";
                $parte_estado = "AND cp.estado_cambio IN (1,2)";
            }
            if(session('usuario')->id_puesto=="32" || 
            session('usuario')->id_puesto=="33" || 
            session('usuario')->id_puesto=="167"){
                $parte_base = "AND cp.base='".session('usuario')->centro_labores."'";
                $parte_estado = "AND cp.estado_cambio=2";
            }

            $sql = "SELECT cp.id_cambio_prenda,DATE_FORMAT(cp.fec_reg, '%Y-%m-%d') AS fecha,cp.base,
                    CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) 
                    AS registrado_por,cp.n_documento,
                    (SELECT SUM(cd.n_cant_vent) FROM cambio_prenda_detalle cd
                    WHERE cd.id_cambio_prenda=cp.id_cambio_prenda) AS cant_total,
                    CASE WHEN cp.id_motivo=6 THEN cp.otro ELSE mc.nom_motivo END AS nom_motivo,
                    cp.nuevo_num_comprobante,
                    cp.nuevo_num_serie,CASE WHEN cp.estado_cambio=1 THEN 'Pendiente de aprobación'
                    WHEN cp.estado_cambio=2 THEN 'Aprobado' WHEN cp.estado_cambio=3 THEN 'Denegado'
                    WHEN cp.estado_cambio=4 THEN 'Finalizado' END AS estado_ap,cp.estado_cambio,
                    DATE_FORMAT(cp.fecha, '%Y-%m-%d') AS fecha_compra,cp.hora,cp.nom_cliente,cp.telefono,
                    cp.vendedor,cp.num_caja
                    FROM cambio_prenda cp
                    INNER JOIN users us ON cp.user_reg=us.id_usuario
                    INNER JOIN motivo_cprenda mc ON cp.id_motivo=mc.id_motivo
                    WHERE YEAR(cp.fec_reg)='".$dato['anio']."' $parte_base AND 
                    cp.tipo_boleta=".$dato['tipo']." $parte_estado AND cp.estado=1
                    ORDER BY cp.fec_reg DESC";
            $query = DB::select($sql);
            return $query;
        }
    }
}
