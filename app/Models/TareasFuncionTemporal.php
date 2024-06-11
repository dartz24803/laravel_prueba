<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareasFuncionTemporal extends Model
{
    use HasFactory;

    protected $table = 'tareas_funcion_temporal';

    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];
}
