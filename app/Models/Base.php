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
        $sql = "SELECT cod_base FROM base 
                WHERE id_base IN (2,3,4,5,6,7,8,9,10,31,13,27,33,14,37)
                ORDER BY cod_base";
        $query = DB::select($sql);
        return $query;
    }

    public function buscar($id)
    {
        return $this->where('id_base', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->select('cod_base')->where('estado',1)->distinct()->orderBy("cod_base",'ASC')->get()->toArray();
    }

    public static function get_list_base_tracking()
    {
        $sql = "SELECT id_base,cod_base FROM base 
                WHERE id_base IN (2,3,4,5,6,7,8,9,10,31,13,27,33,14,37,21)
                ORDER BY cod_base";
        $query = DB::select($sql);
        return $query;
    }

    //listar bases para select en ccv
    function listar_bases_b(){
        return $this->select('id_base','cod_base')->where('cod_base','LIKE', 'B%')->orderBy("cod_base",'ASC')->get()->toArray();
    }

    public static function get_list_base_administrador()
    {
        $sql = "SELECT cod_base FROM base
                WHERE estado=1 AND cod_base LIKE 'B%'
                GROUP BY cod_base
                ORDER BY cod_base ASC";
        $query = DB::select($sql);
        return $query;
    }
}
