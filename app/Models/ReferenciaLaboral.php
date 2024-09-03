<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenciaLaboral extends Model
{
    use HasFactory;

    protected $table = 'referencia_laboral';
    protected $primaryKey = 'id_referencia_laboral';

    public $timestamps = false;

    protected $fillable = [
        'cod_referencia_laboral',
        'nom_referencia_laboral',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
