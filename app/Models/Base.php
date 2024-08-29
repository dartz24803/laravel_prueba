<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Base extends Model
{
    use HasFactory;

    protected $table = 'base';
    protected $primaryKey = 'id_base';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'nom_base',
        'id_empresa',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'direccion',
        'tiempo_llegada',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_bases_tienda()
    {
        $sql = "SELECT id_base,cod_base FROM base 
                WHERE id_base IN (2,3,4,5,6,7,8,9,10,31,13,27,14,37)
                ORDER BY cod_base ASC";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_base_tracking()
    {
        $sql = "SELECT id_base,cod_base FROM base 
                WHERE id_base IN (2,3,4,5,6,7,8,9,10,31,13,27,14,37,21)
                ORDER BY cod_base ASC";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_todas_bases_agrupadas()
    {
        $sql = "SELECT cod_base FROM base 
                WHERE estado=1 AND id_base!=33
                GROUP BY cod_base
                ORDER BY cod_base ASC";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_base_only()
    {
        $centro_labores = session('usuario')->centro_labores;
        $id_puesto = session('usuario')->id_puesto;
        $id_nivel = session('usuario')->id_nivel;

        if ($id_puesto == 23 || $id_puesto == 26 || $id_nivel == 1 || $id_puesto == 27) {
            $buscar = " ";
        } elseif ($id_puesto == 128) {
            $buscar = " and cod_base not in ('OFC', 'CD' , 'AMT', 'DEED', 'EXT', 'ZET') ";
        } elseif ($centro_labores === "CD" || $centro_labores === "OFC" || $centro_labores === "AMT") {
            $buscar = " and cod_base in ('OFC', 'CD', 'AMT') ";
        } else {
            $buscar = " ";
        }

        $sql = "SELECT cod_base from base WHERE
                estado='1' $buscar GROUP BY `cod_base` order by cod_base ASC";
        $query = DB::select($sql);

        return json_decode(json_encode($query), true);
    }
}
