<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ControlMercaderiaActivo extends Model
{
    // Define the table name if it doesn't follow the Laravel naming convention
    protected $table = 'control_mercaderia_activo';

    // Define the primary key
    protected $primaryKey = 'id_control_mercaderia_activo';

    public $timestamps = false;

    // Define the columns that can be mass assigned
    protected $fillable = [
        'doc_despacho',
        'estado_control',
        'user_conf_salida',
        'fec_conf_salida',
        'user_conf_recepcion',
        'fec_conf_recepcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];


    static function list_control_mercaderia_activo_ln1($dato){
        $sql = "SELECT c.*,
        case
        when c.estado_control=1 then 'Guía Emitida'
        when c.estado_control=2 then 'En tránsito'
        when c.estado_control=3 then 'Recepcionado (CD)'
        when c.estado_control=4 then 'En tránsito'
        when c.estado_control=5 then 'Recepcionado (Base)' end as desc_estado
        FROM control_mercaderia_activo c
        WHERE c.estado=1 ";

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
