<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingGuiaRemisionDetalle extends Model
{
    use HasFactory;

    protected $table = 'tracking_guia_remision_detalle';

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
