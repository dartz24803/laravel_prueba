<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSupervisionTienda extends Model
{
    use HasFactory;

    protected $table = 'detalle_supervision_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_supervision_tienda',
        'id_contenido',
        'valor'
    ];
}
