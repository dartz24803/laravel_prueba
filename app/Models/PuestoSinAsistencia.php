<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoSinAsistencia extends Model
{
    use HasFactory;

    protected $table = 'vw_puesto_sin_asistencia';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'nom_puesto'
    ];
}
