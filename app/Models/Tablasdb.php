<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablasdb extends Model
{
    use HasFactory;

    protected $table = 'tablas_db';
    protected $primaryKey = 'idtablas_db';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cod_db',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
