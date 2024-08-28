<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioReproceso extends Model
{
    use HasFactory;

    protected $table = 'usuario_reproceso';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nombre',
    ];
}
