<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingTransporteArchivo extends Model
{
    use HasFactory;

    protected $table = 'tracking_transporte_archivo';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking_transporte',
        'archivo'
    ];
}
