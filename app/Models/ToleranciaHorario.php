<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ToleranciaHorario extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tolerancia_horario';

    protected $primaryKey = 'id_tolerancia';

    protected $fillable = [
        'tolerancia',
        'tipo',
        'estado_registro',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function consulta_tolerancia_horario_activo(){ 
        $sql = "SELECT a.*,CASE WHEN a.tipo=1 THEN a.tolerancia 
                WHEN a.tipo=2 THEN a.tolerancia*60 END AS minutos 
                FROM tolerancia_horario a 
                WHERE a.estado=1 AND a.estado_registro=1";
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

}
