<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingPago extends Model
{
    use HasFactory;

    protected $table = 'tracking_pago';

    public $timestamps = false;

    protected $fillable = [
        'id_base',
        'anio',
        'semana',
        'guia_remision'
    ];
}
