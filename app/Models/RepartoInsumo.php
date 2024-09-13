<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RepartoInsumo extends Model
{
    use HasFactory;
    
    protected $table = 'reparto_insumo';
    protected $primaryKey = 'id_reparto_insumo';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'id_insumo',
        'cantidad_reparto',
        'fec_reparto',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_reparto_insumo()
    {
        if(session('usuario')->id_puesto=="31" || session('usuario')->id_puesto=="32"){
            $parte = "ri.cod_base='".session('usuario')->centro_labores."' AND";
        }else{
            $parte = "";
        }
        $sql = "SELECT ri.id_reparto_insumo,ri.fec_reparto AS orden,iu.nom_insumo,
                DATE_FORMAT(ri.fec_reparto,'%d-%m-%Y') AS fecha,ri.cod_base,ri.cantidad_reparto
                FROM reparto_insumo ri
                INNER JOIN insumo iu ON iu.id_insumo=ri.id_insumo
                WHERE $parte ri.estado=1 
                ORDER BY ri.fec_reparto DESC";
        $query = DB::select($sql);
        return $query;
    }
}
