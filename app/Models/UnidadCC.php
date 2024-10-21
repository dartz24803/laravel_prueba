<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadCC extends Model
{
    use HasFactory;

    protected $table = 'vw_unidad_caja_chica';

    public $timestamps = false;

    protected $fillable = [
        'id_unidad',
        'nom_unidad'
    ];
}
