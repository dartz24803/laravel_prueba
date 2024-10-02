<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consumible extends Model
{
    use HasFactory;

    protected $table = 'consumible';
    protected $primaryKey = 'id_consumible';

    public $timestamps = false;

    protected $fillable = [
        'cod_consumible',
        'id_area',
        'id_usuario',
        'observacion',
        'estado_consumible',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];



    static function get_list_consumible($id_consumible)
    {
        if (isset($id_consumible) && $id_consumible > 0) {
            $sql = "SELECT * FROM consumible where id_consumible=$id_consumible";
        } else {

            $sql = "SELECT c.*,date_format(c.fec_reg,'%d-%m-%Y') as  fecha_solicitud,
            a.nom_area,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.centro_labores,
            case when c.estado_consumible=1 then 'Requerido'
            when c.estado_consumible=2 then 'En Procedo de Atención'
            when c.estado_consumible=3 then 'Observado'
            when c.estado_consumible=4 then 'Subsanado'
            when c.estado_consumible=5 then 'Atendido' end as desc_estado_consumible
           FROM consumible c
           left join area a on c.id_area=a.id_area
           left join users u on c.id_usuario=u.id_usuario
           where c.estado=1";
        }
        $query = DB::select($sql);

        return $query;
    }
}
