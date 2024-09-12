<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    use HasFactory;

    protected $table = 'talla';

    public $timestamps = false;

    protected $primaryKey = 'id_talla';

    protected $fillable = [
        'id_accesorio',
        'cod_talla',
        'nom_talla',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
