<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoTemporal extends Model
{
    use HasFactory;

    protected $table = 'archivo_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'tabla',
        'archivo'
    ];
}
