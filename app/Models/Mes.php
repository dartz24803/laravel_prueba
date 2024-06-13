<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    use HasFactory;

    protected $table = 'mes';
    protected $primaryKey = 'id_mes';

    public $timestamps = false;

    protected $fillable = [
        'cod_mes',
        'nom_mes',
        'abr_mes',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
