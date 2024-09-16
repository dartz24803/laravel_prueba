<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTotalInsumo extends Model
{
    use HasFactory;

    protected $table = 'stock_total_insumo';

    public $timestamps = false; 

    protected $fillable = [
        'id_insumo',
        'nom_insumo',
        'total'
    ];
}
