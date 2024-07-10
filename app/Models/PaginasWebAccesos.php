<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaginasWebAccesos extends Model
{
    use HasFactory;

    protected $table = 'paginas_web_accesos';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'area',
        'puesto',
        'pagina_acceso',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}