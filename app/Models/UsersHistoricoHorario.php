<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersHistoricoHorario extends Model
{
    use HasFactory;

    protected $table = 'users_historico_horario';

    public $timestamps = false;

    protected $primaryKey = 'id_historico_horario';

    protected $fillable = [
        'id_usuario',
        'id_horario',
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
    
    static function get_list_historico_horario_colaborador($id_usuario){
        $sql = "SELECT a.*,b.nombre
        FROM users_historico_horario a 
        left join horario b on a.id_horario=b.id_horario
        WHERE a.estado=1 and a.id_usuario=$id_usuario order by a.fec_reg desc";
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
