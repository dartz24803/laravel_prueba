<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercaderiaSurtidaPadre extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'mercaderia_surtida_padre';

    public $timestamps = false; 

    protected $fillable = [
        'base',
        'estilo',
        'fecha',
    ];
}
