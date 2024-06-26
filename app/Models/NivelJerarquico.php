<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelJerarquico extends Model
{
    use HasFactory;

    protected $table = 'nivel_jerarquico';
    protected $primaryKey = 'id_nivel';

    public $timestamps = false;

    protected $fillable = [
        'nom_nivel',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
