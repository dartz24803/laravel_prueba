<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiendas extends Model
{
    use HasFactory;

    protected $table = 'tiendas';
    protected $primaryKey = 'id_tienda';

    public $timestamps = false;

    protected $fillable = [
        'id_sede',
        'id_local',
        'ronda',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
