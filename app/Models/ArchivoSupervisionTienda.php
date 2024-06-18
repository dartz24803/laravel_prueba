<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoSupervisionTienda extends Model
{
    use HasFactory;

    protected $table = 'archivos_supervision_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_supervision_tienda',
        'archivo'
    ];
}
