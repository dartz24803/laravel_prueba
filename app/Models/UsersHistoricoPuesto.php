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
        left join gerencia b on a.id_gerencia=b.id_gerencia
        left join area c on a.id_area=c.id_area
        left join puesto d on a.id_puesto=d.id_puesto
        left join tipo_cambio_puesto e on a.id_tipo_cambio=e.id_tipo_cambio
        WHERE a.estado=1 and a.id_usuario=$id_usuario order by a.fec_reg desc";
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
