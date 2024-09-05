<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GrupoSanguineo extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'grupo_sanguineo';

    protected $primaryKey = 'id_grupo_sanguineo';
    
    protected $fillable = [
        'cod_grupo_sanguineo',
        'nom_grupo_sanguineo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
