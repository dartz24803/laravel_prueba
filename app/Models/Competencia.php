<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    protected $table = 'competencia';
    protected $primaryKey = 'id_competencia';

    public $timestamps = false;

    protected $fillable = [
        'nom_competencia',
        'def_competencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}