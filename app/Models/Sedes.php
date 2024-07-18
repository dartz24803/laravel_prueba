<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    use HasFactory; 

    protected $table = 'sedes';
    protected $primaryKey = 'id_sede';

    public $timestamps = false;

    protected $fillable = [
        'nombre_sede',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
