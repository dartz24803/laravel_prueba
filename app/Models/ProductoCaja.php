<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCaja extends Model
{
    use HasFactory;

    protected $table = 'producto_caja';
    protected $primaryKey = 'id_producto';

    public $timestamps = false;

    protected $fillable = [
        'id_marca',
        'id_modelo',
        'id_unidad',
        'id_color',
        'id_categoria',
        'nom_producto',
        'id_estado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
