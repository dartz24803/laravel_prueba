<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zona extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'zona_p';

    protected $primaryKey = 'id_zona';
    
    protected $fillable = [
        'numero',
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
