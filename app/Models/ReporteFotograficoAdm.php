<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReporteFotograficoAdm extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reporte_fotografico_adm_new';

    protected $fillable = [
        'id',
        'area',
        'tipo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function listar()
    {
        $query = "SELECT rfa.id,rfa.categoria,rfa.fec_reg, GROUP_CONCAT(a.nom_area ORDER BY rfd.id DESC SEPARATOR ', ') as detalles
            FROM reporte_fotografico_adm_new rfa
            LEFT JOIN reporte_fotografico_detalle_new rfd
            ON rfa.id = rfd.id_reporte_fotografico_adm
            LEFT JOIN area a
            ON rfd.id_area = a.id_area
            WHERE rfa.estado='1'
            GROUP BY rfa.id,rfa.categoria,rfa.fec_reg;";
        $result = DB::select($query);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }


}
