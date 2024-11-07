<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambioPuesto extends Model
{
    use HasFactory;

    protected $table = 'vw_tipo_cambio_puesto';

    public $timestamps = false;

    protected $fillable = [
        'id_tipo_cambio',
        'nom_tipo_cambio'
    ];
}
