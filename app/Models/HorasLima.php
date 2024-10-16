<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasLima extends Model
{
    use HasFactory;

    protected $table = 'hora_lima';
    protected $primaryKey = 'id_hora';

    public $timestamps = false;

    protected $fillable = [
        'id_sede',
        'hora',
        'orden',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
