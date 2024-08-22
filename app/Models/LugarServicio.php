<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LugarServicio extends Model
{
    use HasFactory;

    protected $table = 'vw_lugar_servicio';

    public $timestamps = false;

    protected $fillable = [
        'id_lugar_servicio',
        'nom_lugar_servicio'
    ];
}
