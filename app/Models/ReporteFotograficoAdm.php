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
        return $this->select('reporte_fotografico_adm.*')
        ->leftJoin('area', 'reporte_fotografico_adm.area', '=', 'area.id_area')
        ->where('reporte_fotografico_adm.estado', 1)
        ->get()
        ->toArray();
    }

}
