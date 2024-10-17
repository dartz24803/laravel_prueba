<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoporteSolucion extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'soporte_solucion';

    protected $primaryKey = 'idsoporte_solucion';

    public $timestamps = false;

    protected $fillable = [
        'id_responsable',      // bigint(20)
        'comentario',          // text
        'fec_comentario',      // datetime
        'estado_solucion',     // int(11)
        'archivo_solucion',    // int(11)
        'estado',              // int(11)
        'fec_reg',             // int(11)
        'user_reg',            // int(11)
        'user_act',            // int(11)
        'fec_act',             // int(11)
    ];
}
