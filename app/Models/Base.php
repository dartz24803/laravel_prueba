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

    //NO MODIFICAR SIN COORDINACIÓN PREVIA, YA QUE SE USA EN VARIOS MÓDULOS
    public static function get_list_bases_tienda()
    {
        $sql = "SELECT id_base,cod_base FROM base
                WHERE id_base IN (2,3,4,5,6,7,8,9,10,31,13,27,14,37,68)
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
                WHERE estado=1 AND id_base NOT IN (1,11,12,30,33,35,36)
                GROUP BY cod_base
                ORDER BY cod_base ASC";
        $query = DB::select($sql);
        return $query;
    }
    public static function get_list_todas_bases_agrupadas_bi()
    {
        $sql = "SELECT MIN(id_base) AS id_base, cod_base
                FROM base
                WHERE estado = 1
                  AND id_base NOT IN (1, 11, 12, 30, 33, 35, 36)
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

        if ($id_nivel == 1 ||
        $id_puesto == 23 ||
        $id_puesto == 26 ||
        $id_puesto == 27 ||
        $id_puesto == 158 ||
        $id_puesto == 209) {
            $buscar = "";
        } elseif ($id_puesto == 128) {
            $buscar = "AND cod_base not in ('OFC', 'CD' , 'AMT', 'DEED', 'EXT', 'ZET') ";
        } elseif ($centro_labores === "CD" || $centro_labores === "OFC" || $centro_labores === "AMT") {
            $buscar = "AND cod_base in ('OFC', 'CD', 'AMT') ";
        } else {
            $buscar = "";
        }

        $sql = "SELECT cod_base FROM base
                WHERE estado=1 AND id_base NOT IN (1,11,12,30,33,35,36) $buscar
                GROUP BY cod_base
                ORDER BY cod_base ASC";
        $query = DB::select($sql);

        return json_decode(json_encode($query), true);
    }

    public static function get_list_base_pendiente()
    {
        $sql = "SELECT cod_base FROM base
                WHERE estado=1 AND (cod_base LIKE 'B%' OR cod_base IN ('OFC','CD','AMT')) AND
                cod_base NOT IN ('B00','B01','B02','B13','B14','B17','BV')
                GROUP BY cod_base
                ORDER BY cod_base ASC";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_bases()
    {
        $sql = "SELECT * from base
        WHERE nom_base LIKE 'BASE%' order by nom_base ASC ";

        $result = DB::select($sql);
        return $result;
    }
}
