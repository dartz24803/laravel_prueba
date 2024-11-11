<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cap extends Model
{
    use HasFactory;

    protected $table = 'cap';

    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'id_ubicacion',
        'id_puesto',
        'aprobado',
        'asistencia',
        'libre',
        'falta',
        'fec_reg',
        'user_reg'
    ];
}
