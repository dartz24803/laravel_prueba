<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class EstudiosGenerales extends Model
{
    protected $table = 'estudios_generales';
    protected $primaryKey = 'id_estudios_generales';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_grado_instruccion',
        'carrera',
        'centro',
        'documentoe',
        'documentoe_nombre',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_list_estudiosgu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_grado_instruccion, p.nom_grado_instruccion from estudios_generales rf
                    LEFT JOIN grado_instruccion p on p.id_grado_instruccion=rf.id_grado_instruccion
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_grado_instruccion, p.nom_grado_instruccion from estudios_generales rf
            LEFT JOIN grado_instruccion p on p.id_grado_instruccion=rf.id_grado_instruccion
            where rf.estado=1";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_estudiosge($id_estudios_generales=null){
        if(isset($id_estudios_generales) && $id_estudios_generales > 0){
            $sql = "SELECT rf.*, p.id_grado_instruccion, p.nom_grado_instruccion from estudios_generales rf
                    LEFT JOIN grado_instruccion p on p.id_grado_instruccion=rf.id_grado_instruccion
                    where rf.id_estudios_generales =".$id_estudios_generales." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_grado_instruccion, p.nom_grado_instruccion from estudios_generales rf
            LEFT JOIN grado_instruccion p on p.id_grado_instruccion=rf.id_grado_instruccion
            where rf.estado=1";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
