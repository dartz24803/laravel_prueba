<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;

    protected $table = 'distrito';
    protected $primaryKey = 'id_distrito';

    public $timestamps = false;

    protected $fillable = [
        'nombre_distrito',
        'id_provincia',
        'id_departamento',
        'estado'
    ];
}
