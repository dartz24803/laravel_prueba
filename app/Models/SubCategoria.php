<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class SubCategoria extends Model
{
    use HasFactory;

    protected $table = 'sub_categoria';

    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'nombre',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
