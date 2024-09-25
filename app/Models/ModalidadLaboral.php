<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalidadLaboral extends Model
{
    use HasFactory;

    protected $table = 'modalidad_laboral';

    public $timestamps = false;

    protected $primaryKey = 'id_modalidad_laboral';

    protected $fillable = [
        'nom_modalidad_laboral',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
