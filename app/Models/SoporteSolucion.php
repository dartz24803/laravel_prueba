<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SoporteSolucion extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_solucion';

    protected $primaryKey = 'idsoporte_solucion';

    public $timestamps = false;

    protected $fillable = [
        'idsoporte_comentarios',
        'estado_solucion',     // int(11)
        'archivo_solucion',    // int(11)
        'estado',              // int(11)
        'fec_reg',             // int(11)
        'user_reg',            // int(11)
        'user_act',            // int(11)
        'fec_act',             // int(11)
    ];

    public static function getComentariosBySolucion($idsoporte_solucion)
    {

        $comentarios = DB::table('soporte_comentarios as sc')
            ->leftJoin('users as usr', 'sc.id_responsable', '=', 'usr.id_usuario')
            ->select(
                'sc.idsoporte_comentarios',
                'sc.idsoporte_solucion',
                'sc.comentario',
                'sc.fec_comentario',
                'sc.estado',
                'usr.foto',
                DB::raw("CONCAT(usr.usuario_nombres, ' ', usr.usuario_apater, ' ', usr.usuario_amater) AS nombre_responsable_solucion")
            )
            ->where('sc.idsoporte_solucion', $idsoporte_solucion)
            ->orderBy('sc.fec_comentario', 'DESC')
            ->get();

        return $comentarios;
    }
}
