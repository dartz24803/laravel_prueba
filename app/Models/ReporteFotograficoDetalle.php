<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteFotograficoDetalle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'reporte_fotografico_detalle_new';

    protected $fillable = [
        'id_reporte_fotografico_adm',
        'id_area',
    ];
}
