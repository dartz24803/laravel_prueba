<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'tracking';

    public $timestamps = false;

    protected $fillable = [
        'n_requerimiento',
        'n_guia_remision',
        'semana',
        'id_origen_desde',
        'desde',
        'id_origen_hacia',
        'hacia',
        'guia_transporte',
        'peso',
        'paquetes',
        'sobres',
        'fardos',
        'bultos',
        'caja',
        'transporte',
        'nombre_transporte',
        'importe_transporte',
        'factura_transporte',
        'observacion_inspf',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function get_list_tracking(){
        $sql = "SELECT tr.id,tr.n_requerimiento,tr.desde,tr.hacia,'' AS proceso,
                '' AS fecha,'' AS hora,
                '' AS estado
                FROM tracking tr
                WHERE tr.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
