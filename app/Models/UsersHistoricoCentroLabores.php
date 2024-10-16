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
        $sql = "SELECT a.* FROM users_historico_centro_labores a WHERE a.estado=1 and a.id_usuario=$id_usuario 
        order by a.fec_reg desc";
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
