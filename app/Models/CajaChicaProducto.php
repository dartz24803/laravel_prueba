<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaProducto extends Model
{
    use HasFactory;

    protected $table = 'caja_chica_producto';

    public $timestamps = false;

    protected $fillable = [
        'id_caja_chica',
        'cantidad',
        'producto',
        'precio'
    ];
}
