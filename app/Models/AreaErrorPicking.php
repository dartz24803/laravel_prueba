<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaErrorPicking extends Model
{
    use HasFactory;

    protected $table = 'vw_area_error_picking';

    public $timestamps = false;

    protected $fillable = [
        'id_area',
        'nom_area'
    ];
}
