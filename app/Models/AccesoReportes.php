<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccesoReportes extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'acceso_reporte';

    protected $fillable = [
        'id_acceso_reporte',
        'codigo',
        'nom_reporte',
        'id_srea',
        'iframe',
        'descripcion',
        'acceso',
        'acceso_area',
        'acceso_nivel',
        'acceso_gerencia',
        'acceso_base',
        'acceso_todo',
        'div_puesto',
        'div_base',
        'div_area',
        'div_nivel',
        'div_gerencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function buscar($id)
    {
        return $this->where('id_area', $id)->get()->toArray();
    }

    public function listar()
    {
        $query = "SELECT IFNULL(GROUP_CONCAT(CONCAT('\'', REPLACE(a.id_area, ',', '\',\''), '\'') SEPARATOR ','),'0') AS areas
        FROM acceso_reporte a
        WHERE a.estado=1
        and (
            (Session::get('usuario')->id_nivel <> 8) AND
            (a.acceso<>'' and CONCAT(',', a.acceso, ',') LIKE CONCAT('%,', '".Session::get('usuario')->id_puesto."', ',%')) OR
            (a.acceso_base<>'' and CONCAT(',', a.acceso_base, ',') LIKE CONCAT('%,', '".Session::get('usuario')->centro_labores."', ',%')) OR
            (a.acceso_area<>'' and CONCAT(',', a.acceso_area, ',') LIKE CONCAT('%,', '".Session::get('usuario')->centro_laboresid_area."', ',%')) OR
            (a.acceso_gerencia<>'' and CONCAT(',', a.acceso_gerencia, ',') LIKE CONCAT('%,', '".Session::get('usuario')->id_gerencia."', ',%')) OR
            (a.acceso_nivel<>'' and CONCAT(',', a.acceso_nivel, ',') LIKE CONCAT('%,', '".$nivel_jerarquico."', ',%'))
        )";

        $result = DB::select($query);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
