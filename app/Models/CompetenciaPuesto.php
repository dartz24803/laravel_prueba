<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciaPuesto extends Model
{
    use HasFactory;

    protected $table = 'competencia_puesto';
    protected $primaryKey = 'id_competencia_puesto';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'id_competencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}