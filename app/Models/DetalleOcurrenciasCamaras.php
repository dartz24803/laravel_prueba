<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOcurrenciasCamaras extends Model
{
    use HasFactory;

    protected $table = 'detalle_ocurrencias_camaras';
    protected $primaryKey = 'id_detalle_ocurrencias_camaras';

    public $timestamps = false;

    protected $fillable = [
        'id_ocurrencia',
        'id_control_camara',
    ];
}