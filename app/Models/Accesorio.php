<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    use HasFactory;

    protected $table = 'accesorio';

    public $timestamps = false;

    protected $primaryKey = 'id_accesorio';

    protected $fillable = [
        'cod_accesorio',
        'nom_accesorio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
