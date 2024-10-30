<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificacionSocial extends Model
{
    use HasFactory;

    protected $table = 'verificacion_social';
    protected $primaryKey = 'id_ver_social';

    public $timestamps = false;

    protected $fillable = [
        'id_postulante',
        'resultado',
        'ver_social',
        'observaciones',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
