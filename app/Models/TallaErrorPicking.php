<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TallaErrorPicking extends Model
{
    use HasFactory;

    protected $table = 'vw_talla_error_picking';

    public $timestamps = false;

    protected $fillable = [
        'id_talla',
        'nom_talla'
    ];
}
