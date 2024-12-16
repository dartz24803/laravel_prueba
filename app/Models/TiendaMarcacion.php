<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TiendaMarcacion extends Model
{
    use HasFactory;

    protected $table = 'tienda_marcacion';
    protected $primaryKey = 'id_tienda_marcacion';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'cant_foto_ingreso',
        'cant_foto_apertura',
        'cant_foto_cierre',
        'cant_foto_salida',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_tienda_marcacion(){
        $sql = "SELECT tm.id_tienda_marcacion,tm.cod_base,
                (SELECT GROUP_CONCAT(td.nom_dia ORDER BY td.dia ASC SEPARATOR ', ') 
                FROM tienda_marcacion_dia td
                WHERE td.id_tienda_marcacion=tm.id_tienda_marcacion) AS dias
                FROM tienda_marcacion tm
                WHERE tm.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}