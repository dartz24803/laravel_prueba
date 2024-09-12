<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComisionAFP extends Model
{
    use HasFactory;

    protected $table = 'afp';
    protected $primaryKey = 'id_afp';

    public $timestamps = false;

    protected $fillable = [
        'id_sistema_pensionario',
        'cod_afp',
        'nom_afp',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
