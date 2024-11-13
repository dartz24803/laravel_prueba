<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PendienteHistorialC extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'pendiente_historial_c';

    // Llave primaria de la tabla
    protected $primaryKey = 'id_pendiente_historial_c';

    // Deshabilitar timestamps automáticos si no están definidos en la tabla
    public $timestamps = false;

    // Definir los atributos asignables
    protected $fillable = [
        'id_pendiente',
        'id_usuario',
        'comentario',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    static function get_list_historial_comentario_pendiente($id_pendiente){
        $sql = "SELECT p.*,u.usuario_nombres,u.foto_nombre,
                DATE_FORMAT(p.fec_reg, '%d/%m/%Y') AS fecha,
                CONCAT(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) AS comentarista,
                LOWER(CONCAT(SUBSTRING_INDEX(u.usuario_nombres,' ',1),' ',u.usuario_apater)) AS usuario_comentario,
                DATE_FORMAT(p.fec_reg, '%d/%m/%Y %H:%i %p') AS fecha_comentario
                FROM pendiente_historial_c p
                left join users u on u.id_usuario=p.id_usuario
                WHERE p.id_pendiente =$id_pendiente
                ORDER BY p.fec_reg DESC";

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
