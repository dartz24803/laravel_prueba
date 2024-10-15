<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaProductoTmp extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_producto_tmp';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'cantidad',
        'producto',
        'precio'
    ];
}
