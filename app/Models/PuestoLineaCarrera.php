<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoLineaCarrera extends Model
{
    use HasFactory;

    protected $table = 'vw_puesto_linea_carrera';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'nom_puesto'
    ];
}
