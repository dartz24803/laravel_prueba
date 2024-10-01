<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventario extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'inventario';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_inventario';

    // Deshabilitar timestamps automáticos (created_at, updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'cod_inventario',
        'fecha',
        'base',
        'id_responsable',
        'conteo',
        'stock',
        'diferencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Los campos que serán tratados como fechas
    protected $dates = [
        'fecha',
        'fec_reg',
        'fec_act',
        'fec_eli'
    ];

    // Relación con el usuario responsable (asumiendo que tienes un modelo Usuario)
    public function responsable()
    {
        return $this->belongsTo(User::class, 'id_responsable', 'id');
    }


    public static function get_list_inventario()
    {
        $sql = "SELECT a.*, 
                       DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, 
                       b.usuario_nombres, 
                       b.usuario_apater, 
                       b.usuario_amater,
                       COALESCE(SUM(c.conteo), 0) AS conteo,
                       COALESCE(SUM(c.stock), 0) AS stock,
                       COALESCE(SUM(c.diferencia), 0) AS diferencia
                FROM inventario a
                LEFT JOIN users b ON a.id_responsable = b.id_usuario
                LEFT JOIN inventario_detalle c ON c.id_inventario = a.id_inventario AND c.estado = 1
                WHERE a.estado = 1
                GROUP BY a.id_inventario, a.cod_inventario, a.fecha, a.base, a.id_responsable, 
                         a.conteo, a.stock, a.diferencia, a.estado, a.fec_reg, a.user_reg, 
                         a.fec_act, a.user_act, a.fec_eli, a.user_eli, 
                         b.usuario_nombres, b.usuario_apater, b.usuario_amater";

        $query = DB::select($sql);
        return $query;
    }
}
