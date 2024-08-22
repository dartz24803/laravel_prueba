<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcurrenciaArchivo extends Model
{
    use HasFactory;

    protected $table = 'ocurrencia_archivo';
    protected $primaryKey = 'id_ocurrencia_archivo';

    public $timestamps = false;

    protected $fillable = [
        'id_ocurrencia',
        'cod_ocurrencia',
        'archivo',
        'estado',
        'user_reg',
        'fec_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
