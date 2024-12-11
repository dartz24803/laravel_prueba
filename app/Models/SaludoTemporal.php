<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludoTemporal extends Model
{
    use HasFactory;

    protected $table = 'saludo_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'archivo'
    ];
}
