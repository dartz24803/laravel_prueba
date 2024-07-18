<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiendasRonda extends Model
{
    use HasFactory;

    protected $table = 'tiendas_ronda';

    public $timestamps = false;

    protected $fillable = [
        'id_tienda',
        'id_ronda',
        'fecha',
        'usuario'
    ];
}
