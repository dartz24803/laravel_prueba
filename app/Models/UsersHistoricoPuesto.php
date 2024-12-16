<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersHistoricoPuesto extends Model
{
    use HasFactory;

    protected $table = 'users_historico_puesto';

    protected $primaryKey = 'id_historico_puesto';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_direccion',
        'id_gerencia',
        'id_sub_gerencia',
        'id_area',
        'id_puesto',
        'id_centro_labor',
        'fec_inicio',
        'con_fec_fin',
        'fec_fin',
        'id_tipo_cambio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_list_historico_puesto_colaborador($id_usuario){
        $sql = "SELECT a.*,b.nom_gerencia,c.nom_area,d.nom_puesto,e.nom_tipo_cambio
                FROM users_historico_puesto a 
                LEFT JOIN puesto d ON a.id_puesto=d.id_puesto
                LEFT JOIN area c ON d.id_area=c.id_area
                LEFT JOIN sub_gerencia sg ON sg.id_sub_gerencia=c.id_departamento
                LEFT JOIN gerencia b ON sg.id_gerencia=b.id_gerencia
                LEFT JOIN vw_tipo_cambio_puesto e on a.id_tipo_cambio=e.id_tipo_cambio
                WHERE a.estado=1 AND a.id_usuario=$id_usuario 
                ORDER BY a.fec_reg DESC";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
