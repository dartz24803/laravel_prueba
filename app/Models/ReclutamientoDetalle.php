<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReclutamientoDetalle extends Model
{
    use HasFactory;

    protected $table = 'reclutamiento_detalle';

    protected $primaryKey = 'id_reclutamiento_detalle';

    public $timestamps = false;

    protected $fillable = [
        'id_reclutamiento',
        'id_evaluador',
        'id_modalidad_laboral',
        'tipo_sueldo',
        'prioridad',
        'sueldo',
        'desde',
        'a',
        'id_asignado',
        'observacion',
        'fec_enproceso',
        'fec_cierre',
        'fec_cierre_r',
        'estado_reclutamiento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_list_detalle_reclutamiento($id_reclutamiento){
        $sql = "SELECT r.*,u.usuario_nombres,u.usuario_apater,u.usuario_amater,
        u.num_doc,DATE_FORMAT(u.fec_ingreso, '%d/%m/%Y') as fec_ingreso,
        DATE_FORMAT(u.ini_funciones, '%d/%m/%Y') as ini_funciones
        FROM reclutamiento_reclutado r 
        left join users u on r.id_usuario=u.id_usuario
        where r.id_reclutamiento='$id_reclutamiento' and r.estado=1 ";
        
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
