<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Puestos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'puesto';

    protected $fillable = [
        'id_direccion',
        'cod_puesto',
        'nom_puesto',
        'nom_puesto_ant',
        'id_gerencia',
        'id_departamento',
        'id_area',
        'proposito',
        'id_nivel',
        'id_sede_laboral',
        'flag_ant',
        'perfil_infosap',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function get_list_puesto_horario($base){
        $sql = "SELECT us.id_puesto,pu.nom_puesto
                FROM users us
                LEFT JOIN puesto pu ON us.id_puesto=pu.id_puesto
                WHERE us.centro_labores='$base' AND us.estado=1 AND pu.nom_puesto NOT LIKE 'BASE%'
                GROUP BY us.id_puesto,pu.nom_puesto
                ORDER BY pu.nom_puesto ASC";

        $result = DB::select($sql);

        return json_decode(json_encode($result), true);
    }
}
