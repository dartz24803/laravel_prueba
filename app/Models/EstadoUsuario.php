<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoUsuario extends Model
{
    use HasFactory;

    protected $table = 'vw_estado_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_estado_usuario',
        'nom_estado_usuario'
    ];
}
