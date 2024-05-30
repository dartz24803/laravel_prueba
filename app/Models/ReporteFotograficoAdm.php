<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReporteFotograficoAdm extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reporte_fotografico_adm';

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
        $query = "SELECT *,rfa.fec_reg AS fecha_registro FROM reporte_fotografico_adm rfa LEFT JOIN area a ON  rfa.area=a.id_area WHERE rfa.estado = 1;";
        $result = DB::select($query);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }


}
