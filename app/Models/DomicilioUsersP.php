<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomicilioUsersP extends Model
{
    use HasFactory;

    protected $table = 'domicilio_usersp';
    protected $primaryKey = 'id_domicilio_usersp';

    public $timestamps = false;

    protected $fillable = [
        'id_postulante',
        'id_distrito',
        'lat',
        'lng',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
