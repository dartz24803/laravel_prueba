<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gerencia extends Model
{
    use HasFactory;

    protected $table = 'gerencia';

    protected $primaryKey = 'id_gerencia';

    protected $fillable = [
        'cod_gerencia',
        'id_direccion',
        'nom_gerencia',
        'nom_gerencia_ant',
        'digitos_cuenta',
        'digitos_cci',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    function get_list_gerencia($id_gerencia=null){
        if(isset($id_gerencia) && $id_gerencia > 0){
            $sql = "SELECT * FROM gerencia WHERE estado='1' and id_gerencia=$id_gerencia";
        }else{
            $sql = "SELECT g.*,d.direccion FROM gerencia g
            left join direccion d on g.id_direccion=d.id_direccion
            WHERE g.estado='1' ";
        }
        $query = DB::select($sql);
        return $query;
    }
}
