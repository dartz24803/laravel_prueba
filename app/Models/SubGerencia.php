<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGerencia extends Model
{
    use HasFactory;

    protected $table = 'sub_gerencia';
    protected $primaryKey = 'id_sub_gerencia';

    public $timestamps = false;

    protected $fillable = [
        'id_direccion',
        'id_gerencia',
        'nom_sub_gerencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
