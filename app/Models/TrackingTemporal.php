<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingTemporal extends Model
{
    use HasFactory;

    protected $table = 'tracking_temporal';

    public $timestamps = false;

    protected $fillable = [
        'n_requerimiento',
        'n_guia_remision',
        'semana',
        'id_origen_desde',
        'desde',
        'id_origen_hacia',
        'hacia',
        'bultos'
    ];
}
