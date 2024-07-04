<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingGuiaRemisionDetalleTemporal extends Model
{
    use HasFactory;

    protected $table = 'tracking_guia_remision_detalle_temporal';

    public $timestamps = false;

    protected $fillable = [
        'n_guia_remision',
        'sku',
        'color',
        'estilo',
        'talla',
        'descripcion',
        'cantidad'
    ];
}
