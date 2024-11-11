<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pendiente extends Model
{
    use HasFactory;

    protected $table = 'pendiente';
    protected $primaryKey = 'id_pendiente';

    public $timestamps = false;
    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'cod_base',
        'cod_pendiente',
        'id_mantenimiento',
        'id_especialidad',
        'titulo',
        'id_tipo',
        'id_area',
        'id_item',
        'id_subitem',
        'dificultad',
        'id_subsubitem',
        'id_responsable',
        'costo',
        'id_prioridad',
        'descripcion',
        'comentario',
        'f_inicio',
        'fecha_vencimiento',
        'f_entrega',
        'envio_mail',
        'conforme',
        'calificacion',
        'flag_programado',
        'id_programacion',
        'equipo_i',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];


    public static function ultimoAnioCodPendiente($dato)
    {
        return self::where('id_tipo', $dato['id_tipo'])
            ->where('id_area', $dato['id_area'])
            ->where('estado', 1)
            ->get();
    }


    static function get_list_gestion_pendiente($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $id_areap= $_SESSION['usuario'][0]['id_area'];

        $cadena="";

        if($dato['cpiniciar']!="0"){
            $cadena.= "1,";
        }
        if($dato['cproceso']!="0"){
            $cadena.= "2,";
        }
        if($dato['cfinalizado']!="0"){
            $cadena.= "3,";
        }
        if($dato['cstandby']!="0"){
            $cadena.= "4,";
        }
        $cadena = substr($cadena, 0, -1);

        $prestado = "(".$cadena.")";
        $estado = "";
        if($prestado!="()"){
            $estado=" AND pe.estado in ".$prestado;
        }

        $filtro="";
        if($dato['mis_tareas']==1){
            $filtro=" AND pe.id_responsable=$id_usuario";
        }else{
            if($dato['responsablei']!="0"){
                $filtro=" AND pe.id_responsable=".$dato['responsablei'];
            }else{
                $filtro=" AND (ar.id_area=$id_areap OR pe.id_responsable=$id_usuario)";
            }

        }

        if(isset($dato['id_area']) && $dato['id_area']>=0 && isset($dato['base']) && $dato['base']>=0){
            $parte="";
            if($dato['id_area']!="0"){
                $parte="AND pe.id_area='".$dato['id_area']."'";
            }
            $partebase="";
            if($dato['base']!="0"){
                $partebase="AND pe.cod_base='".$dato['base']."'";
            }

            $sql = "SELECT pe.*,LOWER(ti.nom_tipo_tickets) AS nom_tipo_tickets,ar.nom_area,ar.orden,
                    pr.nom_prioridad_tickets,es.nom_estado_tickets,
                    it.nom_item,su.nom_subitem,
                    CASE WHEN DATE(pe.fec_reg)=CURDATE() THEN CONCAT('Hoy ',DATE_FORMAT(pe.fec_reg,'%H:%i %p'))
                    WHEN TIMESTAMPDIFF(DAY, DATE(pe.fec_reg), CURDATE())=1 THEN CONCAT('Ayer ',DATE_FORMAT(pe.fec_reg,'%H:%i %p'))
                    ELSE DATE_FORMAT(pe.fec_reg, '%d/%m') END AS fecha_tabla,
                    CASE WHEN pe.id_responsable>0 THEN
                    LOWER(CONCAT(SUBSTRING_INDEX(re.usuario_nombres,' ',1),' ',re.usuario_apater)) ELSE 'Por definir' END AS responsable,
                    it.nom_item,su.nom_subitem,us.centro_labores as base_solicitante,
                    pe.fec_reg AS orden,LOWER(ar.nom_area) AS nom_area_min,LOWER(pe.titulo) AS titulo_min,
                    CASE WHEN pe.f_inicio IS NULL THEN 'Por definir' ELSE
                    DATE_FORMAT(pe.f_inicio,'%d/%m') END AS vence,
                    CASE WHEN pe.f_entrega IS NULL THEN '' ELSE
                    DATE_FORMAT(pe.f_entrega,'%d/%m') END AS termino,
                    LOWER(CONCAT(SUBSTRING_INDEX(so.usuario_nombres,' ',1),' ',so.usuario_apater)) AS solicitante
                    FROM pendiente pe
                    LEFT JOIN tipo_tickets ti ON ti.id_tipo_tickets=pe.id_tipo
                    LEFT JOIN area ar ON ar.id_area=pe.id_area
                    LEFT JOIN item it ON it.id_item=pe.id_item
                    LEFT JOIN subitem su ON su.id_subitem=pe.id_subitem
                    LEFT JOIN users us ON us.id_usuario=pe.id_usuario
                    LEFT JOIN prioridad_tickets pr ON pr.id_prioridad_tickets=pe.id_prioridad
                    LEFT JOIN estado_tickets es ON es.id_estado_tickets=pe.estado
                    LEFT JOIN users re ON re.id_usuario=pe.id_responsable
                    LEFT JOIN users so ON so.id_usuario=pe.id_usuario
                    WHERE pe.estado!=5 $parte $partebase $estado $filtro
                    ORDER BY pe.fec_reg DESC";
        }else{
            $partebase="";
            if($dato['base']!="0"){
                $partebase="AND pe.cod_base='".$dato['base']."'";
            }

            $sql = "SELECT pe.*,LOWER(ti.nom_tipo_tickets) AS nom_tipo_tickets,ar.nom_area,ar.orden,
                    pr.nom_prioridad_tickets,es.nom_estado_tickets,
                    it.nom_item,su.nom_subitem,
                    CASE WHEN DATE(pe.fec_reg)=CURDATE() THEN CONCAT('Hoy ',DATE_FORMAT(pe.fec_reg,'%H:%i %p'))
                    WHEN TIMESTAMPDIFF(DAY, DATE(pe.fec_reg), CURDATE())=1 THEN CONCAT('Ayer ',DATE_FORMAT(pe.fec_reg,'%H:%i %p'))
                    ELSE DATE_FORMAT(pe.fec_reg, '%d/%m') END AS fecha_tabla,
                    CASE WHEN pe.id_responsable>0 THEN
                    LOWER(CONCAT(SUBSTRING_INDEX(re.usuario_nombres,' ',1),' ',re.usuario_apater)) ELSE 'Por definir' END AS responsable,
                    it.nom_item,su.nom_subitem,us.centro_labores as base_solicitante,
                    pe.fec_reg AS orden,LOWER(ar.nom_area) AS nom_area_min,LOWER(pe.titulo) AS titulo_min,
                    CASE WHEN pe.f_inicio IS NULL THEN 'Por definir' ELSE
                    DATE_FORMAT(pe.f_inicio,'%d/%m') END AS vence,
                    CASE WHEN pe.f_entrega IS NULL THEN '' ELSE
                    DATE_FORMAT(pe.f_entrega,'%d/%m') END AS termino,
                    LOWER(CONCAT(SUBSTRING_INDEX(so.usuario_nombres,' ',1),' ',so.usuario_apater)) AS solicitante
                    FROM pendiente pe
                    LEFT JOIN tipo_tickets ti ON ti.id_tipo_tickets=pe.id_tipo
                    LEFT JOIN area ar ON ar.id_area=pe.id_area
                    LEFT JOIN item it ON it.id_item=pe.id_item
                    LEFT JOIN subitem su ON su.id_subitem=pe.id_subitem
                    LEFT JOIN users us ON us.id_usuario=pe.id_usuario
                    LEFT JOIN prioridad_tickets pr ON pr.id_prioridad_tickets=pe.id_prioridad
                    LEFT JOIN estado_tickets es ON es.id_estado_tickets=pe.estado
                    LEFT JOIN users re ON re.id_usuario=pe.id_responsable
                    LEFT JOIN users so ON so.id_usuario=pe.id_usuario
                    WHERE pe.estado!=5 $filtro $partebase $estado
                    ORDER BY pe.fec_reg DESC";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
