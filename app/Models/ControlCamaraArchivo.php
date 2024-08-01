<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCamaraArchivo extends Model
{
    use HasFactory;

    protected $table = 'control_camara_archivo';

    public $timestamps = false;

    protected $fillable = [
        'id_control_camara',
        'id_ronda',
        'archivo'
    ];
}
