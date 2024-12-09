<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tickets extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'tickets';

    // Clave primaria
    protected $primaryKey = 'id_tickets';

    // Deshabilitar timestamps automáticos (created_at y updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'id_usuario_solic',
        'id_usuario_soporte',
        'link',
        'verif_email',
        'cod_tickets',
        'id_tipo_tickets',
        'plataforma',
        'id_prioridad_tickets',
        'dificultad',
        'titulo_tickets',
        'descrip_ticket',
        'coment_ticket',
        'finalizado_por',
        'estado',
        'ticket_ini',
        'ticket_fin',
        'f_inicio',
        'f_fin',
        'fecha_vencimiento',
        'f_inicio_real',
        'f_fin_real',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    static function get_list_tickets($dato){
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
        $estado="";
        if($prestado!="()"){
            $estado=" AND t.estado in ".$prestado;
        }

        $parte_plataforma="";
        if($dato['plataforma']!=0){
            $parte_plataforma="AND t.plataforma='".$dato['plataforma']."'";
        }

        $parte_base="";
        if($dato['base']!="0"){
            $parte_base="AND so.centro_labores='".$dato['base']."'";
        }

        $parte_area="";
        if($dato['area']!=0){
            $parte_area="AND pu.id_area='".$dato['area']."'";
        }

        $sql = "SELECT t.id_tickets,t.fec_reg AS orden,CASE WHEN DATE(t.fec_reg)=CURDATE()
                THEN CONCAT('Hoy ',DATE_FORMAT(t.fec_reg,'%H:%i %p'))
                WHEN TIMESTAMPDIFF(DAY, DATE(t.fec_reg), CURDATE())=1
                THEN CONCAT('Ayer ',DATE_FORMAT(t.fec_reg,'%H:%i %p'))
                ELSE DATE_FORMAT(t.fec_reg, '%d/%m') END AS fecha_tabla,
                SUBSTRING(tt.nom_tipo_tickets,1,3) AS tipo,UPPER(mo.cod_modulo) AS nom_plataforma,
                LOWER(a.nom_area) AS nom_area_min,
                LOWER(CONCAT(SUBSTRING_INDEX(so.usuario_nombres,' ',1),' ',so.usuario_apater))
                AS solicitante,LOWER(t.titulo_tickets) AS titulo_min,
                CASE WHEN t.finalizado_por>0 THEN
                LOWER(CONCAT(SUBSTRING_INDEX(sp.usuario_nombres,' ',1),' ',sp.usuario_apater))
                ELSE 'Por definir' END AS soporte,
                CASE WHEN t.f_fin IS NULL THEN 'Por definir' ELSE
                DATE_FORMAT(t.f_fin,'%d/%m') END AS vence,
                CASE WHEN t.f_fin_real IS NULL THEN 'Por definir' ELSE
                DATE_FORMAT(t.f_fin_real,'%d/%m') END AS termino,t.estado,es.nom_estado_tickets,
                CASE WHEN t.fec_act IS NULL THEN '0 Día(s)' ELSE
                CONCAT(TIMESTAMPDIFF(DAY,DATE(t.fec_act),CURDATE()),' Día(s)')
                END AS diferencia_dias,
                t.verif_email,so.centro_labores AS cod_base,t.cod_tickets,t.descrip_ticket,
                co.descripcion AS dificultad,t.f_fin
                FROM tickets t
                LEFT JOIN tipo_tickets tt ON t.id_tipo_tickets=tt.id_tipo_tickets
                LEFT JOIN modulo mo ON t.plataforma=mo.id_modulo
                LEFT JOIN users so ON t.id_usuario_solic=so.id_usuario
                LEFT JOIN puesto pu ON pu.id_puesto=so.id_puesto
                LEFT JOIN area a ON a.id_area=pu.id_area
                LEFT JOIN users sp ON t.finalizado_por=sp.id_usuario
                LEFT JOIN estado_tickets es ON t.estado=es.id_estado_tickets
                LEFT JOIN complejidad co ON co.id_complejidad=t.dificultad
                WHERE t.estado!=5 $estado $parte_plataforma $parte_base $parte_area
                ORDER BY t.fec_reg DESC";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    function get_list_tickets_usuario($dato){
        $id_usuario= session('usuario')->id_usuario;

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
        $estado="";
        if($prestado!="()"){
            $estado=" AND t.estado in ".$prestado;
        }

        $parte_plataforma="";
        if($dato['plataforma']!=0){
            $parte_plataforma="AND t.plataforma='".$dato['plataforma']."'";
        }

        $sql = "SELECT t.id_tickets,t.fec_reg AS orden,CASE WHEN DATE(t.fec_reg)=CURDATE()
                THEN CONCAT('Hoy ',DATE_FORMAT(t.fec_reg,'%H:%i %p'))
                WHEN TIMESTAMPDIFF(DAY, DATE(t.fec_reg), CURDATE())=1
                THEN CONCAT('Ayer ',DATE_FORMAT(t.fec_reg,'%H:%i %p'))
                ELSE DATE_FORMAT(t.fec_reg, '%d/%m') END AS fecha_tabla,
                SUBSTRING(tt.nom_tipo_tickets,1,3) AS tipo,UPPER(mo.cod_modulo) AS nom_plataforma,
                LOWER(a.nom_area) AS nom_area_min,
                LOWER(CONCAT(SUBSTRING_INDEX(so.usuario_nombres,' ',1),' ',so.usuario_apater))
                AS solicitante,LOWER(t.titulo_tickets) AS titulo_min,
                CASE WHEN t.finalizado_por>0 THEN
                LOWER(CONCAT(SUBSTRING_INDEX(sp.usuario_nombres,' ',1),' ',sp.usuario_apater))
                ELSE 'Por definir' END AS soporte,
                CASE WHEN t.f_fin IS NULL THEN 'Por definir' ELSE
                DATE_FORMAT(t.f_fin,'%d/%m') END AS vence,
                CASE WHEN t.f_fin_real IS NULL THEN 'Por definir' ELSE
                DATE_FORMAT(t.f_fin_real,'%d/%m') END AS termino,t.estado,es.nom_estado_tickets,
                CASE WHEN t.fec_act IS NULL THEN '0 Día(s)' ELSE
                CONCAT(TIMESTAMPDIFF(DAY,DATE(t.fec_act),CURDATE()),' Día(s)')
                END AS diferencia_dias,
                so.centro_labores AS cod_base,t.cod_tickets,t.descrip_ticket,
                co.descripcion AS dificultad
                FROM tickets t
                LEFT JOIN tipo_tickets tt ON t.id_tipo_tickets=tt.id_tipo_tickets
                LEFT JOIN modulo mo ON t.plataforma=mo.id_modulo
                LEFT JOIN users so ON t.id_usuario_solic=so.id_usuario
                LEFT JOIN puesto pu ON pu.id_puesto=so.id_puesto
                LEFT JOIN area a ON a.id_area=pu.id_area
                LEFT JOIN users sp ON t.finalizado_por=sp.id_usuario
                LEFT JOIN estado_tickets es ON t.estado=es.id_estado_tickets
                LEFT JOIN complejidad co ON co.id_complejidad=t.dificultad
                WHERE t.estado!=5 AND t.id_usuario_solic=$id_usuario $estado $parte_plataforma
                ORDER BY t.fec_reg DESC";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

}
