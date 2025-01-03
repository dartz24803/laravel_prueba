<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoErrorPicking extends Model
{
    use HasFactory;

    protected $table = 'vw_tipo_error_picking';

    public $timestamps = false;

    protected $fillable = [
        'id_tipo_error',
        'nom_tipo_error'
    ];
}
