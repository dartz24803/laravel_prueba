<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercaderiaSurtida extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'mercaderia_surtida';

    public $timestamps = false; 

    protected $fillable = [
        'base',
        'anio',
        'semana',
        'sku',
        'estilo',
        'tipo_usuario',
        'tipo_prenda',
        'color',
        'talla',
        'descripcion',
        'cantidad',
        'fecha',
        'usuario',
    ];
}
