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
        $id_usuario= session('usuario')->id_usuario;
        $id_areap= session('usuario')->id_area;

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

    static function get_id_responsable_gestion_pendiente(){
        $sql="SELECT COALESCE(group_concat(distinct id_responsable), '0') as responsable
        FROM pendiente WHERE estado !=4";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_responsable_gestion_pendiente($dato){
        $sql="SELECT id_usuario,usuario_apater,usuario_amater,usuario_nombres
        FROM users WHERE id_usuario in (".$dato['get_id_resp'][0]['responsable'].")";

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_area_pendiente(){
        if (strpos(session('usuario')->centro_labores, 'B') === 0) {
            $sql = "SELECT * FROM area
                    WHERE estado=1
                    AND (nom_area LIKE 'SEGURIDAD%'
                    OR nom_area LIKE 'RECLUTAMIENTO%'
                    OR nom_area LIKE 'TECNOLOGÍA%'
                    OR nom_area LIKE 'SOPORTE%'
                    OR nom_area LIKE 'COMERCIAL%'
                    OR nom_area LIKE 'MARKETING%'
                    OR nom_area LIKE 'VISUAL%'
                    OR nom_area LIKE 'LOGÍSTICA%'
                    OR nom_area LIKE 'CAJA%'
                    OR nom_area LIKE 'LEGAL%'
                    OR nom_area LIKE 'MANTENIMIENTO%'
                    OR nom_area LIKE 'CONTABILIDAD%')
                    ORDER BY nom_area ASC";
        }else{
            $sql = "SELECT * FROM area
                    WHERE estado=1
                    AND nom_area NOT LIKE 'DTO%'
                    AND nom_area NOT LIKE 'GERENCIA%'
                    ORDER BY nom_area ASC";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_pendiente($id_pendiente=null){
        $id_usuario= session('usuario')->id_usuario;
        
        if(isset($id_pendiente) && $id_pendiente > 0){
            $sql = "SELECT pe.*,ti.nom_tipo_tickets,ar.nom_area,it.nom_item,su.nom_subitem,
                    concat_ws(' ',re.usuario_nombres,re.usuario_apater) as responsable,
                    LOWER(CONCAT(SUBSTRING_INDEX(so.usuario_nombres,' ',1),' ',so.usuario_apater)) AS solicitante,
                    so.usuario_nombres as nom_solicitante,
                    re.usuario_nombres as nom_responsable,
                    DATE_FORMAT(pe.fec_reg, '%d-%m-%Y') AS fecha_registro,
                    pr.nom_prioridad_tickets,es.nom_estado_tickets,ssu.nom_subsubitem,
                    DATE_FORMAT(pe.f_inicio, '%d-%m-%Y') AS fecha_inicio,
                    DATE_FORMAT(pe.f_entrega, '%d-%m-%Y') AS fecha_fin,
                    co.descripcion AS nom_dificultad,CASE WHEN pe.id_mantenimiento=1 THEN 'Recurrente'
                    WHEN pe.id_mantenimiento=2 THEN 'Emergencia' ELSE '' END AS mantenimiento,
                    ep.nombre AS especialidad,tt.nombre AS nom_titulo,pu.id_area AS area_usuario,
                    CONCAT(pe.id_usuario,'-',pe.cod_base,'-',pu.id_area) AS usuario_editar
                    FROM pendiente pe
                    LEFT JOIN tipo_tickets ti ON ti.id_tipo_tickets=pe.id_tipo
                    LEFT JOIN area ar ON ar.id_area=pe.id_area
                    LEFT JOIN item it ON it.id_item=pe.id_item
                    LEFT JOIN subitem su ON su.id_subitem=pe.id_subitem
                    LEFT JOIN subsubitem ssu ON ssu.id_subsubitem=pe.id_subsubitem
                    LEFT JOIN users re ON re.id_usuario=pe.id_responsable
                    LEFT JOIN users so ON so.id_usuario=pe.id_usuario
                    INNER JOIN puesto pu ON pu.id_puesto=so.id_puesto
                    LEFT JOIN prioridad_tickets pr ON pr.id_prioridad_tickets=pe.id_prioridad
                    LEFT JOIN estado_tickets es ON es.id_estado_tickets=pe.estado
                    LEFT JOIN complejidad co ON co.id_complejidad=pe.dificultad
                    LEFT JOIN especialidad ep ON pe.id_especialidad=ep.id
                    LEFT JOIN titulo tt ON pe.titulo=tt.id
                    WHERE pe.id_pendiente =$id_pendiente";
        }
        else{ 
            $sql = "SELECT pe.*,ti.nom_tipo_tickets,ar.nom_area,ar.orden,
                    concat_ws(' ',us.usuario_nombres,us.usuario_apater) as solicitante,
                    pr.nom_prioridad_tickets,es.nom_estado_tickets,
                    DATE_FORMAT(pe.fec_reg, '%Y-%m-%d %H:%i:%s') AS fecha_tabla,
                    concat_ws(' ',re.usuario_nombres,re.usuario_apater) as responsable,
                    it.nom_item,su.nom_subitem
                    FROM pendiente pe
                    LEFT JOIN tipo_tickets ti ON ti.id_tipo_tickets=pe.id_tipo
                    LEFT JOIN area ar ON ar.id_area=pe.id_area
                    LEFT JOIN item it ON it.id_item=pe.id_item
                    LEFT JOIN subitem su ON su.id_subitem=pe.id_subitem
                    LEFT JOIN users us ON us.id_usuario=pe.id_usuario
                    LEFT JOIN prioridad_tickets pr ON pr.id_prioridad_tickets=pe.id_prioridad
                    LEFT JOIN estado_tickets es ON es.id_estado_tickets=pe.estado
                    LEFT JOIN users re ON re.id_usuario=pe.id_responsable
                    WHERE pe.estado!=4 AND pe.id_usuario=$id_usuario
                    ORDER BY ar.orden ASC";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static 
    function busqueda_list_pendiente($dato){
        $id_usuario= session('usuario')->id_usuario;
        $centro_labores= session('usuario')->centro_labores;
        
        $area="";
        if($dato['area']!=0){
            $area="AND pe.id_area='".$dato['area']."'";
        }

        $cadena="";
        
        if($dato['piniciar']!="0"){
            $cadena.= "1,";
        }
        if($dato['proceso']!="0"){
            $cadena.= "2,";
        }
        if($dato['finalizado']!="0"){
            $cadena.= "3,";
        }
        if($dato['standby']!="0"){
            $cadena.= "4,";
        } 

        $cadena = substr($cadena, 0, -1);

        $prestado = "(".$cadena.")";
        $estado="";
        if($prestado!="()"){
            if($area==""){
                $estado=" AND pe.estado in ".$prestado;
            }else{
                $estado=" AND pe.estado in ".$prestado;
            }
            
        }else{
            if($area==""){
                $estado=" AND pe.estado !=4 ";
            }else{
                $estado=" AND pe.estado !=4 ";
            }
        }

        if(session('usuario')->id_nivel==1){
            $sql = "SELECT pe.*,ti.nom_tipo_tickets,ar.nom_area,ar.orden,
                    concat_ws(' ',us.usuario_nombres,us.usuario_apater) as solicitante,
                    pr.nom_prioridad_tickets,es.nom_estado_tickets,
                    CASE WHEN DATE(pe.fec_reg)=CURDATE() THEN CONCAT('Hoy ',DATE_FORMAT(pe.fec_reg,'%H:%i %p'))
                    WHEN TIMESTAMPDIFF(DAY, DATE(pe.fec_reg), CURDATE())=1 THEN CONCAT('Ayer ',DATE_FORMAT(pe.fec_reg,'%H:%i %p')) 
                    ELSE DATE_FORMAT(pe.fec_reg, '%d/%m') END AS fecha_tabla,
                    CASE WHEN pe.id_responsable>0 THEN 
                    LOWER(CONCAT(SUBSTRING_INDEX(re.usuario_nombres,' ',1),' ',re.usuario_apater)) ELSE 'Por definir' END AS responsable,
                    it.nom_item,su.nom_subitem,us.centro_labores as base_solicitante,
                    pe.fec_reg AS orden,LOWER(ar.nom_area) AS nom_area_min,
                    CASE WHEN pe.f_inicio IS NULL THEN 'Por definir' ELSE 
                    DATE_FORMAT(pe.f_inicio,'%d/%m') END AS vence,
                    LOWER(CONCAT(SUBSTRING_INDEX(ur.usuario_nombres,' ',1),' ',ur.usuario_apater)) AS 
                    usuario_solicitante,CASE WHEN pe.id_area=10 OR pe.id_area=41 AND pe.id_mantenimiento IN (1,2) THEN tt.nombre 
                    ELSE LOWER(pe.titulo) END AS titulo_min,
                    CASE WHEN pe.f_inicio IS NULL THEN 'Por definir' ELSE 
                    DATE_FORMAT(pe.f_inicio,'%d-%m-%Y') END AS vence_excel
                    FROM pendiente pe
                    LEFT JOIN tipo_tickets ti ON ti.id_tipo_tickets=pe.id_tipo
                    LEFT JOIN area ar ON ar.id_area=pe.id_area
                    LEFT JOIN item it ON it.id_item=pe.id_item
                    LEFT JOIN subitem su ON su.id_subitem=pe.id_subitem
                    LEFT JOIN users us ON us.id_usuario=pe.id_usuario
                    LEFT JOIN prioridad_tickets pr ON pr.id_prioridad_tickets=pe.id_prioridad
                    LEFT JOIN estado_tickets es ON es.id_estado_tickets=pe.estado
                    LEFT JOIN users re ON re.id_usuario=pe.id_responsable
                    LEFT JOIN users ur ON pe.id_usuario=ur.id_usuario
                    LEFT JOIN titulo tt ON pe.titulo=tt.id
                    WHERE pe.id_usuario IS NOT NULL $area $estado
                    ORDER BY pe.fec_reg DESC";
        }else{ 
            if((session('usuario')->id_puesto==16 || session('usuario')->id_puesto==20 || 
            session('usuario')->id_puesto==26 || session('usuario')->id_puesto==27 || 
            session('usuario')->id_puesto==98 || session('usuario')->id_puesto==128 || 
            session('usuario')->id_puesto==29) && strlen(session('usuario')->centro_labores)==3 &&
            substr(session('usuario')->centro_labores,0,1)=="B"){ 
                $parte = "pe.cod_base='$centro_labores'";
            }else{
                $parte = "pe.id_usuario='$id_usuario'";
            }
            $sql = "SELECT pe.*,ti.nom_tipo_tickets,ar.nom_area,ar.orden,
                    concat_ws(' ',us.usuario_nombres,us.usuario_apater) as solicitante,
                    pr.nom_prioridad_tickets,es.nom_estado_tickets,
                    CASE WHEN DATE(pe.fec_reg)=CURDATE() THEN CONCAT('Hoy ',DATE_FORMAT(pe.fec_reg,'%H:%i %p'))
                    WHEN TIMESTAMPDIFF(DAY, DATE(pe.fec_reg), CURDATE())=1 THEN CONCAT('Ayer ',DATE_FORMAT(pe.fec_reg,'%H:%i %p')) 
                    ELSE DATE_FORMAT(pe.fec_reg, '%d/%m') END AS fecha_tabla,
                    CASE WHEN pe.id_responsable>0 THEN 
                    LOWER(CONCAT(SUBSTRING_INDEX(re.usuario_nombres,' ',1),' ',re.usuario_apater)) ELSE 'Por definir' END AS responsable,
                    it.nom_item,su.nom_subitem,us.centro_labores as base_solicitante,
                    pe.fec_reg AS orden,LOWER(ar.nom_area) AS nom_area_min,
                    CASE WHEN pe.f_inicio IS NULL THEN 'Por definir' ELSE 
                    DATE_FORMAT(pe.f_inicio,'%d/%m') END AS vence,
                    LOWER(CONCAT(SUBSTRING_INDEX(ur.usuario_nombres,' ',1),' ',ur.usuario_apater)) AS 
                    usuario_solicitante,CASE WHEN pe.id_area=10 OR pe.id_area=41 AND pe.id_mantenimiento IN (1,2) THEN tt.nombre 
                    ELSE LOWER(pe.titulo) END AS titulo_min,
                    CASE WHEN pe.f_inicio IS NULL THEN 'Por definir' ELSE 
                    DATE_FORMAT(pe.f_inicio,'%d-%m-%Y') END AS vence_excel
                    FROM pendiente pe
                    LEFT JOIN tipo_tickets ti ON ti.id_tipo_tickets=pe.id_tipo
                    LEFT JOIN area ar ON ar.id_area=pe.id_area
                    LEFT JOIN item it ON it.id_item=pe.id_item
                    LEFT JOIN subitem su ON su.id_subitem=pe.id_subitem
                    LEFT JOIN users us ON us.id_usuario=pe.id_usuario
                    LEFT JOIN prioridad_tickets pr ON pr.id_prioridad_tickets=pe.id_prioridad
                    LEFT JOIN estado_tickets es ON es.id_estado_tickets=pe.estado
                    LEFT JOIN users re ON re.id_usuario=pe.id_responsable
                    LEFT JOIN users ur ON pe.id_usuario=ur.id_usuario
                    LEFT JOIN titulo tt ON pe.titulo=tt.id
                    WHERE $parte $area $estado
                    ORDER BY pe.fec_reg DESC";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_usuario_pendiente($puestos,$cod_base){
        $sql = "SELECT us.id_usuario,us.centro_labores,pu.id_area,
                CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) AS usuario 
                FROM users us
                INNER JOIN puesto pu ON pu.id_puesto=us.id_puesto
                INNER JOIN ubicacion ub ON ub.id_ubicacion=us.id_centro_labor AND 
                ub.cod_ubi='$cod_base'
                WHERE us.estado=1";
                
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
