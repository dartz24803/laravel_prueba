<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Area extends Model
{
    use HasFactory;

    protected $table = 'area';
    protected $primaryKey = 'id_area';

    public $timestamps = false;

    protected $fillable = [
        'cod_area',
        'nom_area',
        'id_departamento',
        'puestos',
        'orden',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'id_base'
    ];

    public function buscar($id)
    {
        return $this->where('id_area', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->where('estado', 1)->orderBy("id_area", 'DESC')->get()->toArray();
    }

    public static function get_list_area()
    {
        $sql = "SELECT ar.id_area,di.direccion,ge.nom_gerencia,dc.nom_sub_gerencia,ar.nom_area,ar.cod_area,
                (SELECT GROUP_CONCAT(pu.nom_puesto)
                FROM puesto pu
                WHERE FIND_IN_SET(pu.id_puesto,ar.puestos)) AS puestos,ar.orden
                FROM area ar
                /*
                INNER JOIN direccion di ON ar.id_direccion=di.id_direccion
                INNER JOIN gerencia ge ON ar.id_gerencia=ge.id_gerencia
                INNER JOIN sub_gerencia dc ON ar.id_departamento=dc.id_sub_gerencia*/

                LEFT JOIN sub_gerencia dc on dc.id_sub_gerencia=ar.id_departamento
                LEFT JOIN gerencia ge on ge.id_gerencia=dc.id_gerencia
                LEFT JOIN direccion di ON ge.id_direccion=di.id_direccion
                WHERE ar.estado=1";
        $query = DB::select($sql);
        return $query;
    }

    public static function obtenerNombreArea($id_area)
    {
        if (!$id_area) {
            throw new \InvalidArgumentException('El ID del área es requerido');
        }
        $nombreArea = DB::table('area')
            ->where('id_area', $id_area)
            ->value('nom_area');
        if (!$nombreArea) {
            throw new \Exception('Área no encontrada');
        }
        return $nombreArea;
    }
}
