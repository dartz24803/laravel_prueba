<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'solicitante',
        'id_tipo',
        'leido',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_notificacion($dato=null){ 
        $sql = "SELECT nt.id_notificacion,nt.id_tipo,co.mensaje,co.icono,
                CASE WHEN nt.id_tipo=45 THEN pu.nom_puesto WHEN nt.id_tipo=46 THEN '' 
                ELSE CONCAT_WS(' ',us.usuario_nombres,us.usuario_apater) 
                END AS solicitante,DATE_FORMAT(nt.fec_reg, '%d-%m-%Y %H:%i:%s') AS fecha
                FROM notificacion nt
                LEFT JOIN config co ON nt.id_tipo=co.id_config
                LEFT JOIN users us ON nt.solicitante=us.id_usuario
                LEFT JOIN puesto pu ON nt.solicitante=pu.id_puesto
                WHERE nt.id_usuario=".session('usuario')->id_usuario." AND nt.leido=0 AND nt.estado=1
                ORDER BY nt.fec_reg DESC";
        $query = DB::select($sql);
        return $query;
    }
}
