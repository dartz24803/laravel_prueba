<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCamaraArchivoTemporal extends Model
{
    use HasFactory;

    protected $table = 'control_camara_archivo_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_tienda',
        'id_ronda',
        'archivo'
    ];
}
