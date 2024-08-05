<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrasesInicio extends Model
{
    use HasFactory;

    protected $table = 'inicio_frases';

    public $timestamps = false;

    // protected $primaryKey = 'id';

    protected $fillable = [
        'frase',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
