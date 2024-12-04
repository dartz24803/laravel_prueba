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
        'estado_solucion',
        'archivo_solucion',
        'estado',
        'archivo1',
        'archivo2',
        'archivo3',
        'archivo4',
        'archivo5',
        'documento1',
        'documento2',
        'documento3',
        'fec_reg',
        'user_reg',
        'user_act',
        'fec_act',
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

    public static function getComentariosUserBySolucion($idsoporte_solucion)
    {
        $id_usuario = session('usuario')->id_usuario;
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
            ->where('sc.id_responsable', $id_usuario)
            ->orderBy('sc.fec_comentario', 'DESC')
            ->get();

        return $comentarios;
    }
}
