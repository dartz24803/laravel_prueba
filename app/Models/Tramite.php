<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tramite extends Model
{
    protected $table = 'tramite';

    protected $primaryKey = 'id_tramite';

    public $timestamps = false;

    protected $fillable = [
        'id_destino',
        'nom_tramite',
        'cantidad_uso',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_list_tramite($id_tramite=null){
        if(isset($id_tramite) && $id_tramite>0){
            $sql = "SELECT tr.*,de.id_motivo FROM tramite tr
                    LEFT JOIN destino de ON de.id_destino=tr.id_destino
                    WHERE tr.id_tramite=$id_tramite";
        }else{
            $sql = "SELECT tr.*,CASE WHEN de.id_motivo=1 THEN 'Laboral' WHEN de.id_motivo=2 THEN 'Personal' ELSE '' END AS nom_motivo,
                    de.nom_destino
                    FROM tramite tr
                    LEFT JOIN destino de ON de.id_destino=tr.id_destino
                    WHERE tr.estado=1";
        }
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
