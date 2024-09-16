<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedeLaboral extends Model
{
    use HasFactory;

    protected $table = 'sede_laboral';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
