<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoError extends Model
{
    use HasFactory;

    protected $table = 'tipo_error';
    protected $primaryKey = 'id_tipo_error';

    public $timestamps = false;

    protected $fillable = [
        'nom_tipo_error',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
