<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $table = 'banco';
    protected $primaryKey = 'id_banco';

    public $timestamps = false;

    protected $fillable = [
        'cod_banco',
        'nom_banco',
        'digitos_cuenta',
        'digitos_cci',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
