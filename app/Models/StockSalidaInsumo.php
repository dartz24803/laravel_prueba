<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSalidaInsumo extends Model
{
    use HasFactory;

    protected $table = 'stock_salida_insumo';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'nom_insumo', 
        'total'
    ];
}
