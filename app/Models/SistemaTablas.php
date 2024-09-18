<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaTablas extends Model
{
    use HasFactory;

    protected $table = 'sistema_tablas';
    protected $primaryKey = 'id_sistema_tablas';

    public $timestamps = false;

    protected $fillable = [
        'cod_sistema',
        'nom_sistema',
        'cod_db',
        'nom_db',
        'descripcion_sistema',
        'descripcion_db',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
