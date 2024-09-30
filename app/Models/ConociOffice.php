<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConociOffice extends Model
{
    protected $table = 'conoci_office';
    protected $primaryKey = 'id_conoci_office';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_nivel_conocimiento',
        'nl_excel',
        'nl_word',
        'nl_ppoint',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_id_conoci_office($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from conoci_office where id_usuario =".$id_usuario;
        }else{
            $sql = "select * from conoci_office";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
