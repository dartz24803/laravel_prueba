<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    protected $table = 'error';
    protected $primaryKey = 'id_error';

    public $timestamps = false;

    protected $fillable = [
        'nom_error',
        'id_tipo_error',
        'monto',
        'automatico',
        'archivo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
