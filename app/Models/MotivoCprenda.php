<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivoCprenda extends Model
{
    use HasFactory;

    protected $table = 'motivo_cprenda';
    protected $primaryKey = 'id_motivo';

    public $timestamps = false;

    protected $fillable = [
        'nom_motivo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
