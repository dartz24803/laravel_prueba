<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivosAperturaCierreTienda extends Model
{
    use HasFactory;

    protected $table = 'archivos_apertura_cierre_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_apertura_cierre',
        'archivo'
    ];
}
