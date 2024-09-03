<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Regimen extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'regimen';

    protected $primaryKey = 'id_regimen';
    
    protected $fillable = [
        'cod_regimen',
        'nom_regimen',
        'dia_vacaciones',
        'da_mes',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
