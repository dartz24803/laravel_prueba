<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegimenLaboral extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'regimen_laboral';

    protected $primaryKey = 'id_regimen_laboral';
    
    protected $fillable = [
        'codigo',
        'descripcion',
        'descripcion_abreviada',
        'sectorpv',
        'sectorpb',
        'otras',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
