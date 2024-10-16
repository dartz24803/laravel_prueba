<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersHistoricoCentroLabores extends Model
{
    use HasFactory;

    protected $table = 'users_historico_centro_labores';

    public $timestamps = false;

    protected $primaryKey = 'id_historico_centro_labores';

    protected $fillable = [
        'id_usuario',
        'id_ubicacion',
        'centro_labores',
        'con_fec_fin',
        'fec_inicio',
        'fec_fin',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
    static function get_list_historico_base_colaborador($id_usuario){
        $sql = "SELECT uc.*,ub.cod_ubi AS centro_labores
                FROM users_historico_centro_labores uc
                LEFT JOIN ubicacion ub ON ub.id_ubicacion=uc.id_ubicacion
                WHERE uc.estado=1 AND uc.id_usuario=$id_usuario 
                ORDER BY uc.fec_reg DESC";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
